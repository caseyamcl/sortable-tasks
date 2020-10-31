<?php


namespace SortableTasks\Fixture\Task;

use SortableTasks\Fixture\Model\Task;

/**
 * StepC depends on StepA, and must run before StepB
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class TaskC extends Task
{
    /**
     * @inheritDoc
     */
    public static function dependsOn(): iterable
    {
        return [TaskA::class];
    }

    /**
     * @inheritDoc
     */
    public static function mustRunBefore(): iterable
    {
        return [TaskB::class];
    }
}
