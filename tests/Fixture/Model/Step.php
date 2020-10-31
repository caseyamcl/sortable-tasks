<?php


namespace SortableTasks\Fixture\Model;

use SortableTasks\SortableTask;

/**
 * Class Step
 */
abstract class Step implements SortableTask
{
    public static function dependsOn(): iterable
    {
        return [];
    }

    public static function mustRunBefore(): iterable
    {
        return [];
    }


    public function __invoke(StepInput $input): StepReport
    {
        $stepName = static::class;
        return new StepReport("Ran step $stepName", $input);
    }
}
