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
