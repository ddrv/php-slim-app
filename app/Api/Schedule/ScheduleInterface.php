<?php

namespace App\Api\Schedule;

interface ScheduleInterface
{

    /**
     * @return string[]
     */
    public function run();

    /**
     * @return JobInterface[]
     */
    public function getJobs();
}