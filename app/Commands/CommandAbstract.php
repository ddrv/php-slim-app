<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;

abstract class CommandAbstract extends Command
{
    protected $shedule;

    public function shedule()
    {
        return $this->shedule;
    }

}