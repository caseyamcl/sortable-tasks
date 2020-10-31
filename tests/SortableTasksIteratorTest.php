<?php

/**
 * Sortable Tasks Library
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/caseyamcl/sortable-tasks
 * @version 1
 * @package caseyamcl/sortable-tasks
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * ------------------------------------------------------------------
 */

declare(strict_types=1);

namespace SortableTasks;

use Iterator;
use MJS\TopSort\CircularDependencyException;
use MJS\TopSort\ElementNotFoundException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SortableTasks\Fixture\Model\TaskInput;
use SortableTasks\Fixture\Model\TaskReport;
use SortableTasks\Fixture\Task\TaskA;
use SortableTasks\Fixture\Task\TaskB;
use SortableTasks\Fixture\Task\TaskC;
use SortableTasks\Fixture\Task\TaskD;
use SortableTasks\Fixture\Task\TaskE;
use SortableTasks\Fixture\Task\TaskF;
use SortableTasks\Fixture\Task\TaskH;
use SortableTasks\Fixture\Task\TaskThrowsException;
use SortableTasks\Fixture\TaskRunner;

/**
 * Class SortableTasksIteratorTest
 * @package SortableTasks
 */
class SortableTasksIteratorTest extends TestCase
{
    public function testInstantiate(): void
    {
        $sorter = new SortableTasksIterator();
        $this->assertInstanceOf(SortableTasksIterator::class, $sorter);
    }

    public function testBasicDependencies(): void
    {
        $sorter = new SortableTasksIterator();
        $sorter->add(new TaskA());
        $sorter->add(new TaskB());
        $sorter->add(new TaskC());
        $this->assertSame(['A', 'C', 'B'], $this->processTasks($sorter->sort()));
    }

    public function testTwoWayDependency(): void
    {
        $sorter = new SortableTasksIterator();
        $sorter->add(new TaskA());
        $sorter->add(new TaskB()); // depends: "A"
        $sorter->add(new TaskC()); // depends: "A"; before "B"
        $sorter->add(new TaskD()); // depends: "A"; before: "B" & "C"

        $this->assertSame(['A', 'D', 'C', 'B'], $this->processTasks($sorter->sort()));
    }

    public function testBuildInstantiator(): void
    {
        $iterator = SortableTasksIterator::build(new TaskA(), new TaskB(), new TaskC());
        $this->assertSame(['A', 'C', 'B'], $this->processTasks($iterator->sort()));
    }

    public function testCount(): void
    {
        $sorter = new SortableTasksIterator();
        $sorter->add(new TaskA());
        $sorter->add(new TaskB());
        $this->assertSame(2, $sorter->count());
    }

    public function testCountWhenSortIteratorIsEmpty(): void
    {
        $sorter = new SortableTasksIterator();
        $this->assertSame(0, $sorter->count());
        $this->assertSame(0, count($sorter));
    }

    public function testDependencyLoopThrowsException(): void
    {
        $this->expectException(CircularDependencyException::class);
        $this->expectExceptionMessage('Circular dependency found:');

        $sorter = new SortableTasksIterator();
        $sorter->add(new TaskE());
        $sorter->add(new TaskF());
        $this->processTasks($sorter);
    }

    public function testElementNotFoundThrowsException(): void
    {
        $this->expectException(ElementNotFoundException::class);
        $this->expectExceptionMessage(TaskA::class);

        $sorter = new SortableTasksIterator();
        $sorter->add(new TaskB());

        /** @noinspection PhpParamsInspection */
        iterator_apply($sorter->getIterator(), fn ($v) => $v);
    }

    public function testTaskWithExceptionThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('error occurred during processing');

        $sorter = new SortableTasksIterator();
        $sorter->add(new TaskA());
        $sorter->add(new TaskThrowsException());
        $this->processTasks($sorter);
    }

    public function testStepWithInput()
    {
        $sorter = SortableTasksIterator::build(new TaskA(), new TaskB());

        foreach (TaskRunner::runTasks($sorter, new TaskInput(['a' => 'A'])) as $stepResult) {
            $this->assertEquals(['a' => 'A'], $stepResult->getParams()->getValue());
        }
    }

    public function testTaskThatUsesGeneratorToDefineDependencies(): void
    {
        $sorter = SortableTasksIterator::build(new TaskH(), new TaskA(), new TaskB(), new TaskC(), new TaskD());
        $this->assertEquals(['A', 'D', 'C', 'B', 'H'], $this->processTasks($sorter));
    }

    /**
     * @param iterable $taskSortResult
     * @param TaskInput|null $input
     * @return array|TaskReport[]
     */
    private function processTasks(iterable $taskSortResult, ?TaskInput $input = null): array
    {
        $items = TaskRunner::runTasks($taskSortResult, $input);

        if ($items instanceof Iterator) {
            $items = iterator_to_array($items);
        } else {
            $items = (array) $items;
        }

        return array_map('strval', array_values($items));
    }
}
