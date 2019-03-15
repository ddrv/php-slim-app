<?php

namespace App\Api\Schedule;

interface JobInterface
{

    /**
     * @return string
     */
    public function getExpression();

    /**
     * @return string
     */
    public function getCommand();

    /**
     * @return string[]
     */
    public function getOptions();
}