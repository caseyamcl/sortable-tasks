<?php


namespace SortableTasks\Fixture\Step;

use SortableTasks\Fixture\Model\Step;

/**
 * StepB depends on StepA
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class StepB extends Step
{

    public static function dependsOn(): iterable
    {
        return [StepA::class];
    }
}
