<?php

/**
 * Sortable Tasks Library
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/caseyamcl/sortable-tasks
 * @version 1
 * @package caseyamcl/sortable-tasks
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * ------------------------------------------------------------------
 */

declare(strict_types=1);

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
