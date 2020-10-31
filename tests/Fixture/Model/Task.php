<?php


namespace SortableTasks\Fixture\Model;

use SortableTasks\SortableTask;

/**
 * Class Step
 */
abstract class Task implements SortableTask
{
    public static function dependsOn(): iterable
    {
        return [];
    }

    public static function mustRunBefore(): iterable
    {
        return [];
    }


    public function __invoke(TaskInput $input): TaskReport
    {
        $stepName = static::class;
        return new TaskReport("Ran step $stepName", $input);
    }
}
