<?php

namespace SortableTasks\Fixture\Step;

use SortableTasks\Fixture\Model\Step;

/**
 * StepD depends on StepA, and must run before StepB and StepC
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class StepD extends Step
{
    /**
     * @inheritDoc
     */
    public static function dependsOn(): iterable
    {
        return [StepA::class];
    }

    /**
     * @inheritDoc
     */
    public static function mustRunBefore(): iterable
    {
        return [StepB::class, StepC::class];
    }
}
