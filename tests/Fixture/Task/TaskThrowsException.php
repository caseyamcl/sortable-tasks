<?php


namespace SortableTasks\Fixture\Task;

use RuntimeException;
use SortableTasks\Fixture\Model\Task;
use SortableTasks\Fixture\Model\TaskInput;
use SortableTasks\Fixture\Model\TaskReport;

class TaskThrowsException extends Task
{
    public static function dependsOn(): iterable
    {
        return [TaskA::class];
    }

    public static function mustRunBefore(): iterable
    {
        return [TaskC::class];
    }

    public function __invoke(TaskInput $input): TaskReport
    {
        throw new RuntimeException('error occurred during processing');
    }
}
