<?php

namespace SortableTasks\Fixture;

use SortableTasks\Fixture\Model\StepInput;

class TaskRunner
{
    public static function runTasks(iterable $tasks, ?StepInput $input = null): iterable
    {
        $input = $input ?: new StepInput(['a' => 'B']);

        foreach ($tasks as $taskName => $task) {
            yield $taskName => $task->__invoke($input);
        }
    }
}
