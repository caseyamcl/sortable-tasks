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
