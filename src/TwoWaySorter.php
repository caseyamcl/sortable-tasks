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

/**
 * Two-way sorter contains basic logic to support sorting with MJS\TopSort
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class TwoWaySorter implements IteratorAggregate, Countable
{
    private ?TopSortInterface $sorter;

    /**
     * @var array|string[]
     */
    private array $tasks = [];

    /**
     * @var array|string[]
     */
    private array $extraDependencies = [];

    /**
     * TwoWaySorter constructor.
     * @param TopSortInterface|null $sorter
     */
    public function __construct(?TopSortInterface $sorter = null)
    {
        $this->sorter = $sorter ?: new StringSort();
    }

    /**
     * Add item and its dependencies
     *
     * @param string $task
     * @param array|string[] $dependencies
     * @param array|string[] $mustRunBefore
     */
    public function add(string $task, array $dependencies = [], array $mustRunBefore = []): void
    {
        $this->tasks[$task] = $dependencies;

        if (!empty($mustRunBefore)) {
            foreach ($mustRunBefore as $depName) {
                $this->extraDependencies[$depName][] = $task;
            }
        }
    }

    public function contains(string $task): bool
    {
        return array_key_exists($task, $this->tasks);
    }

    /**
     * Sort items and return iterator
     *
     * @param string|null ...$mustRunFirst
     * @return ArrayIterator
     * @throws CircularDependencyException
     * @throws ElementNotFoundException
     */
    public function getIterator(?string ...$mustRunFirst): ArrayIterator
    {
        $extraDependencies = $this->extraDependencies;

        if (count($this->tasks) === 0) {
            return new ArrayIterator([]);
        }

        if (! empty($mustRunFirst)) {
            $allDependencies = array_keys($this->tasks);

            foreach ($mustRunFirst as $mrf) {
                if (! array_key_exists($mrf, $this->tasks)) {
                    throw new ElementNotFoundException(
                        'Element not found: ' . $mrf,
                        0,
                        null,
                        '',
                        ''
                    );
                }

                // Remove the element...
                array_splice(
                    $allDependencies,
                    array_search($mrf, $allDependencies),
                    1
                );

                //...and re-add all of the items as dependencies in the local $extraDependencies array
                // TODO: LEFT OFF HERE
            }
        }

        $sorter = clone $this->sorter;

        foreach ($this->tasks as $item => $dependencies) {
            // fancy logic here...
            if (isset($extraDependencies[$item])) {
                $dependencies = array_merge($dependencies, $this->extraDependencies[$item]);
            }

            $sorter->add($item, $dependencies);
        }

        return new ArrayIterator($sorter->sort());
    }

    /**
     * Alias for self::getIterator()
     *
     * @param string ...$mustRunFirst
     * @return ArrayIterator
     */
    public function sort(string ...$mustRunFirst): ArrayIterator
    {
        return call_user_func_array([$this, 'getIterator'], $mustRunFirst);
    }

    /**
     * Count items
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->tasks);
    }
}
