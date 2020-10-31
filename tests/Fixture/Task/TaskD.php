<?php

namespace SortableTasks\Fixture\Task;

use SortableTasks\Fixture\Model\Task;

/**
 * StepD depends on StepA, and must run before StepB and StepC
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class TaskD extends Task
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
        return [TaskB::class, TaskC::class];
    }
}
