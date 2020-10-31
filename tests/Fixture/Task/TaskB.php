<?php


namespace SortableTasks\Fixture\Task;

use SortableTasks\Fixture\Model\Task;

/**
 * StepB depends on StepA
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class TaskB extends Task
{

    public static function dependsOn(): iterable
    {
        return [TaskA::class];
    }
}
