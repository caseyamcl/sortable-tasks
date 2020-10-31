<?php


namespace SortableTasks\Fixture\Task;

use SortableTasks\Fixture\Model\Task;

/**
 * Step E depends on Step F, which depends on Step E, thereby creating a dependency loop
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class TaskE extends Task
{
    public static function dependsOn(): iterable
    {
        return [TaskF::class];
    }
}
