<?php


namespace SortableTasks\Fixture\Task;

use SortableTasks\Fixture\Model\Task;

/**
 * Step G depends on a non-existent element
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class TaskG extends Task
{
    public static function dependsOn(): iterable
    {
        return ['NonExistent'];
    }
}
