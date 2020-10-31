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

use SortableTasks\Fixture\Model\Task;

/**
 * StepC depends on StepA, and must run before StepB
 *
 * @author Casey McLaughlin <me@caseymclaughlin.com>
 */
class TaskC extends Task
{
    /**
     * @inheritDoc
     */
    public static function dependsOn(): iterable
    {
        return [TaskA::class];
    }

    /**
     * @inheritDoc
     */
    public static function mustRunBefore(): iterable
    {
        return [TaskB::class];
    }
}
