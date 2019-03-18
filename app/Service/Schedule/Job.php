<?php

namespace App\Service\Schedule;

use App\Api\Schedule\JobInterface;

class Job implements JobInterface
{

    private $expression;

    private $command;

    private $options;

    /**
     * @param string $expression
     * @param string $command
     * @param string[] $options
     */
    public function __construct($expression, $command, $options = [])
    {
        $this->expression = $expression;
        $this->command = $command;
        $this->options = (array)$options;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getExpression()
    {
        return $this->expression;
    }
}