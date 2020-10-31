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

/**
 * Class StepReport
 */
class TaskReport
{
    private string $reportMessage;

    /**
     * @var TaskInput|null
     */
    private ?TaskInput $params;

    public function __construct(string $reportMessage, ?TaskInput $params = null)
    {
        $this->reportMessage = $reportMessage;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getReportMessage(): string
    {
        return $this->reportMessage;
    }

    /**
     * @return TaskInput|null
     */
    public function getParams(): ?TaskInput
    {
        return $this->params;
    }

    public function __toString(): string
    {
        return substr($this->reportMessage, -1);
    }
}
