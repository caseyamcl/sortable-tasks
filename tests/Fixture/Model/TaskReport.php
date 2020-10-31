<?php


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
