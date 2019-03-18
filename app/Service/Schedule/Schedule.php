<?php

namespace App\Service\Schedule;

use App\Api\Schedule\JobInterface;
use App\Api\Schedule\ScheduleInterface;
use App\Support\Background;

class Schedule implements ScheduleInterface
{

    /**
     * @var JobInterface[]
     */
    private $jobs;

    /**
     * @var Background
     */
    private $background;

    public function __construct(Background $background, $schedule = [])
    {
        $this->background = $background;
        foreach ($schedule as $item) {
            $expression = array_key_exists('expression', $item)?$item['expression']:null;
            $command = array_key_exists('command', $item)?$item['command']:null;
            $options = array_key_exists('options', $item)?$item['options']:null;
            if (!$expression || !$command) continue;
            $this->jobs[] = new Job($expression, $command, $options);
        }
    }

    public function run()
    {
        if (empty($this->jobs)) {
            return [];
        }
        $time = time();
        /** @var JobInterface[] $jobs */
        $jobs = [];
        foreach ($this->jobs as $job) {
            if (!$this->checkTime($time, $job->getExpression())) {
                continue;
            }
            $jobs[] = $job;
        }
        $result = [];
        foreach ($jobs as $job) {
            $result[] = $this->background->run($job->getCommand(), $job->getOptions());
        }
        return $result;
    }

    public function getJobs()
    {
        return $this->jobs;
    }

    private function checkTime($time, $cron)
    {
        $cron_parts = explode(' ', $cron);
        if(count($cron_parts) != 5) {
            return false;
        }
        list($min, $hour, $day, $mon, $week) = explode(' ', $cron);
        $check = [
            'min' => 'i',
            'hour' => 'G',
            'day' => 'j',
            'mon' => 'n',
            'week' => 'w'
        ];
        $ranges = [
            'min' => '0-59',
            'hour' => '0-23',
            'day' => '1-31',
            'mon' => '1-12',
            'week' => '0-6',
        ];

        foreach($check as $part => $c) {
            $val = $$part;
            $values = [];
            if(strpos($val, '/') !== false) {
                list($range, $steps) = explode('/', $val);
                if ($range == '*') {
                    $range = $ranges[$part];
                }
                list($start, $stop) = explode('-', $range);
                for($i = $start; $i <= $stop; $i += $steps) {
                    $values[] = $i;
                }
            } else {
                $k = explode(',', $val);
                foreach($k as $v) {
                    if(strpos($v, '-') !== false) {
                        list($start, $stop) = explode('--', $v);
                        for($i = $start; $i <= $stop; $i++) {
                            $values[] = $i;
                        }
                    } else {
                        $values[] = $v;
                    }
                }
            }
            if (!in_array(date($c, $time), $values) && (strval($val) != '*')) {
                return false;
            }
        }
        unset($min, $hour, $day, $mon, $week);
        return true;
    }
}