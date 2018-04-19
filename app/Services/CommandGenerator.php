<?php

namespace App\Services;

use Slim\Router;
use Symfony\Component\Console\Command\Command;

/**
 * Class UriGenerator
 *
 * @property string $php
 * @property string $exec
 * @property Command $cli
 */
class CommandGenerator
{
    /**
     * @var string
     */
    protected $php;

    /**
     * @var string
     */
    protected $exec;

    /**
     * @var string
     */
    protected $cli;

    /**
     * UriGenerator constructor.
     * @param string $php
     * @param string $exec
     * @param Command $cli
     */
    public function __construct($php, $exec, $cli)
    {
        $this->php = $php;
        $this->exec = $exec;
        $this->cli = $cli;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function createCommand($name, $arguments=[])
    {
        $command = $this->exec;
        if (!is_executable($this->exec)) {
            $command = $this->php.' '.$command;
        }
        $command .= ' '.$name;
        return $command;
    }
}