<?php


namespace SortableTasks\Fixture\Model;

/**
 * Class StepReport
 */
class StepReport
{
    private string $reportMessage;

    /**
     * @var StepInput|null
     */
    private ?StepInput $params;

    public function __construct(string $reportMessage, ?StepInput $params = null)
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
     * @return StepInput|null
     */
    public function getParams(): ?StepInput
    {
        return $this->params;
    }

    public function __toString(): string
    {
        return substr($this->reportMessage, -1);
    }
}
