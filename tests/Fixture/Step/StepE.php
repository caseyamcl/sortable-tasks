<?php


namespace SortableTasks\Fixture\Step;

use SortableTasks\Fixture\Model\Step;

/**
 * Step E depends on Step F, which depends on Step E, thereby creating a dependency loop
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class StepE extends Step
{
    public static function dependsOn(): iterable
    {
        return [StepF::class];
    }
}
