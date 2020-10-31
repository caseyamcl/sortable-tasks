<?php

namespace SortableTasks;

/**
 * Class SortableTaskIterator
 *
 * @package SortableTasks
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
