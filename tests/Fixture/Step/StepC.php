<?php


namespace SortableTasks\Fixture\Step;

use SortableTasks\Fixture\Model\Step;

/**
 * StepC depends on StepA, and must run before StepB
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class StepC extends Step
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
        return [StepB::class];
    }
}
