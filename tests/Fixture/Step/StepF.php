<?php


namespace SortableTasks\Fixture\Step;

use SortableTasks\Fixture\Model\Step;

/**
 * Step F depends on Step E, which depends on Step F, thereby creating a dependency loop
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class StepF extends Step
{
    public static function dependsOn(): iterable
    {
        return [StepE::class];
    }
}
