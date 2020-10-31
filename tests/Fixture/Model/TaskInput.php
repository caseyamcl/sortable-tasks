<?php


namespace SortableTasks\Fixture\Model;

/**
 * Class StepInput
 * @package SortableTasks\Fixture\Model
 */
class TaskInput
{
    private array $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->params;
    }
}
