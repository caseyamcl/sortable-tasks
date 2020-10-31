<?php


namespace SortableTasks\Fixture\Step;

use RuntimeException;
use SortableTasks\Fixture\Model\Step;
use SortableTasks\Fixture\Model\StepInput;
use SortableTasks\Fixture\Model\StepReport;

class StepThrowsException extends Step
{
    public static function dependsOn(): iterable
    {
        return [StepA::class];
    }

    public static function mustRunBefore(): iterable
    {
        return [StepC::class];
    }

    public function __invoke(StepInput $input): StepReport
    {
        throw new RuntimeException('error occurred during processing');
    }
}
