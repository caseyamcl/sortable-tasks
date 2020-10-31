<?php

namespace SortableTasks;

use Iterator;
use MJS\TopSort\CircularDependencyException;
use MJS\TopSort\ElementNotFoundException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SortableTasks\Fixture\Model\StepInput;
use SortableTasks\Fixture\Model\StepReport;
use SortableTasks\Fixture\Step\StepA;
use SortableTasks\Fixture\Step\StepB;
use SortableTasks\Fixture\Step\StepC;
use SortableTasks\Fixture\Step\StepD;
use SortableTasks\Fixture\Step\StepE;
use SortableTasks\Fixture\Step\StepF;
use SortableTasks\Fixture\Step\StepThrowsException;
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
        $sorter->add(new StepA());
        $sorter->add(new StepB());
        $sorter->add(new StepC());
        $this->assertSame(['A', 'C', 'B'], $this->processTasks($sorter->sort()));
    }

    public function testTwoWayDependency(): void
    {
        $sorter = new SortableTasksIterator();
        $sorter->add(new StepA());
        $sorter->add(new StepB()); // depends: "A"
        $sorter->add(new StepC()); // depends: "A"; before "B"
        $sorter->add(new StepD()); // depends: "A"; before: "B" & "C"

        $this->assertSame(['A', 'D', 'C', 'B'], $this->processTasks($sorter->sort()));
    }

    public function testBuildInstantiator(): void
    {
        $iterator = SortableTasksIterator::build(new StepA(), new StepB(), new StepC());
        $this->assertSame(['A', 'C', 'B'], $this->processTasks($iterator->sort()));
    }

    public function testCount(): void
    {
        $sorter = new SortableTasksIterator();
        $sorter->add(new StepA());
        $sorter->add(new StepB());
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
        $sorter->add(new StepE());
        $sorter->add(new StepF());
        $this->processTasks($sorter);
    }

    public function testElementNotFoundThrowsException(): void
    {
        $this->expectException(ElementNotFoundException::class);
        $this->expectExceptionMessage(StepA::class);

        $sorter = new SortableTasksIterator();
        $sorter->add(new StepB());

        /** @noinspection PhpParamsInspection */
        iterator_apply($sorter->getIterator(), fn ($v) => $v);
    }

    public function testTaskWithExceptionThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('error occurred during processing');

        $sorter = new SortableTasksIterator();
        $sorter->add(new StepA());
        $sorter->add(new StepThrowsException());
        $this->processTasks($sorter);
    }

    public function testStepWithInput()
    {
        $sorter = SortableTasksIterator::build(new StepA(), new StepB());

        foreach (TaskRunner::runTasks($sorter, new StepInput(['a' => 'A'])) as $stepResult) {
            $this->assertEquals(['a' => 'A'], $stepResult->getParams()->getValue());
        }
    }

    /**
     * @param iterable $taskSortResult
     * @param StepInput|null $input
     * @return array|StepReport[]
     */
    private function processTasks(iterable $taskSortResult, ?StepInput $input = null): array
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
