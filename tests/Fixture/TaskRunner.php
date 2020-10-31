<?php

namespace SortableTasks\Fixture;

use SortableTasks\Fixture\Model\TaskInput;

class TaskRunner
{
    public static function runTasks(iterable $tasks, ?TaskInput $input = null): iterable
    {
        $input = $input ?: new TaskInput(['a' => 'B']);

        foreach ($tasks as $taskName => $task) {
            yield $taskName => $task->__invoke($input);
        }
    }
}
