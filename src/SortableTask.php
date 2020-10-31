<?php

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
