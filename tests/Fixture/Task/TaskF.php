<?php


namespace SortableTasks\Fixture\Task;

use SortableTasks\Fixture\Model\Task;

/**
 * Step F depends on Step E, which depends on Step F, thereby creating a dependency loop
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class TaskF extends Task
{
    public static function dependsOn(): iterable
    {
        return [TaskE::class];
    }
}
