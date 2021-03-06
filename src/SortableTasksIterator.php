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

use ArrayIterator;
use Countable;
use IteratorAggregate;
use MJS\TopSort\CircularDependencyException;
use MJS\TopSort\ElementNotFoundException;
use MJS\TopSort\Implementations\StringSort;
use MJS\TopSort\TopSortInterface;
use Traversable;

/**
 * Sortable tasks iterator - this class does the work to make `SortableTask` instances
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class SortableTasksIterator implements IteratorAggregate, Countable
{
    private TwoWaySorter $sorter;
    private array $classMap = [];

    /**
     * Build immediately from tasks and use the default StringSort library
     *
     * @param SortableTask ...$tasks
     * @return static
     */
    public static function build(SortableTask ...$tasks): self
    {
        $that = new static();
        call_user_func_array([$that, 'add'], $tasks);
        return $that;
    }

    public function __construct(TopSortInterface $sorter = null)
    {
        $this->sorter = new TwoWaySorter($sorter ?: new StringSort());
    }

    public function add(SortableTask ...$tasks)
    {
        foreach ($tasks as $task) {
            $this->doAdd($task);
        }
    }

    public function contains(string $taskName): bool
    {
        return $this->sorter->contains($taskName);
    }

    /**
     * Sort and return iterator
     *
     * @return iterable
     * @throws CircularDependencyException
     * @throws ElementNotFoundException
     */
    public function getIterator(): iterable
    {
        foreach ($this->sorter->sort() as $taskName) {
            yield $taskName => $this->classMap[$taskName];
        }
    }

    /**
     * Alias for self::getIterator()
     *
     * @return ArrayIterator
     * @throws CircularDependencyException
     * @throws ElementNotFoundException
     */
    public function sort(): iterable
    {
        return $this->getIterator();
    }

    public function count(): int
    {
        return count($this->sorter);
    }

    private function doAdd(SortableTask $task): void
    {
        $taskName = get_class($task);

        $this->classMap[$taskName] = $task;
        $this->sorter->add($taskName, $this->realize($task::dependsOn()), $this->realize($task::mustRunBefore()));
    }

    private function realize(iterable $items): array
    {
        return $items instanceof Traversable ? iterator_to_array($items) : (array) $items;
    }
}
