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

/**
 * Sortable task - implement this interface to make your task sortable, and use the SortableTasksIterator to do the work
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
interface SortableTask
{
    /**
     * Get the task classes that must run before this task
     *
     * @return iterable|string[]
     */
    public static function dependsOn(): iterable;

    /**
     * Get the tasks classes that must run after this task
     *
     * @return iterable|string[]
     */
    public static function mustRunBefore(): iterable;
}
