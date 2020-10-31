<?php


namespace SortableTasks\Fixture\Step;

use SortableTasks\Fixture\Model\Step;

/**
 * Step G depends on a non-existent element
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class StepG extends Step
{
    public static function dependsOn(): iterable
    {
        return ['NonExistent'];
    }
}
