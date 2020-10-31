<?php

namespace SortableTasks;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use MJS\TopSort\CircularDependencyException;
use MJS\TopSort\ElementNotFoundException;
use MJS\TopSort\Implementations\StringSort;
use MJS\TopSort\TopSortInterface;

/**
 * Default implementation of
 *
 * @package SortableTasks
 */
class SortableTasksIterator implements IteratorAggregate, Countable
{
    private ?TopSortInterface $sorter;

    /**
     * @var array|SortableTask[]
     */
    private array $tasks = [];

    /**
     * @var array|array[]  Each sub-array is an array of strings
     */
    private array $extraDependencies = [];

    /**
     * Build immediately from tasks and use the default StringSort library
     *
     * @param SortableTask ...$tasks
     * @return static
     */
    public static function build(SortableTask ...$tasks): self
    {
        $that = new static();
        foreach ($tasks as $task) {
            $that->add($task);
        }
        return $that;
    }

    public function __construct(TopSortInterface $sorter = null)
    {
        $this->sorter = $sorter ?: new StringSort();
    }

    /**
     * @param SortableTask $task
     */
    public function add(SortableTask $task): void
    {
        $taskName = get_class($task);
        $this->tasks[$taskName] = $task;

        if (! empty($task::mustRunBefore())) {
            foreach ($task::mustRunBefore() as $depName) {
                $this->extraDependencies[$depName][] = $taskName;
            }
        }
    }

    public function getIterator(): iterable
    {
        $sorter = clone $this->sorter;

        foreach ($this->tasks as $taskClassName => $step) {
            $dependencies = $step::dependsOn();

            // fancy logic here...
            if (isset($this->extraDependencies[$taskClassName])) {
                $dependencies = array_merge($dependencies, $this->extraDependencies[$taskClassName]);
            }

            $sorter->add($taskClassName, $dependencies);
        }

        foreach ($sorter->sort() as $taskName) {
            yield $taskName => $this->tasks[$taskName];
        }
    }

    /**
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
        return count($this->tasks);
    }
}
