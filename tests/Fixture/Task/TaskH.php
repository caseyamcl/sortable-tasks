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

class TaskH extends Task
{
    // return generator instead of array
    public static function dependsOn(): iterable
    {
        yield TaskA::class;
        yield TaskB::class;
        yield TaskC::class;
        yield TaskD::class;
    }
}
