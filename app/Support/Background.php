<?php

namespace App\Support;

use Symfony\Component\Process\Process;

class Background
{

    /**
     * @var string
     */
    private $exec;

    public function __construct($exec)
    {
        $this->exec = $exec;
    }

    public function run($command, $options = array())
    {
        $run = $this->exec . ' ' . $command;
        if ($options) {
            foreach ($options as $option => $value) {
                $run .= ' ' . '--' . $option . ' "' . addslashes($value) . '"';
            }
        }
        $run .= '  > /dev/null 2>&1 &';
        $process = new Process($run);
        $process->disableOutput();
        $process->run();
        return $run;
    }
}