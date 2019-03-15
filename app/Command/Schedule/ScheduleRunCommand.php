<?php

namespace App\Command\Schedule;

use DateTime;
use App\Api\Schedule\ScheduleInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ScheduleRunCommand extends Command
{

    /**
     * @var ScheduleInterface
     */
    private $schedule;

    public function __construct(ScheduleInterface $schedule, $name)
    {
        parent::__construct();
        $this->schedule = $schedule;
        $this->setName($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Scheduler. Run it every minute by cron.')
            ->setHelp('Scheduler. Run it every minute by cron.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jobs = $this->schedule->run();
        /** @noinspection PhpUnhandledExceptionInspection */
        $time = new DateTime();
        $io = new SymfonyStyle($input, $output);
        $io->text($time->format(DateTime::ATOM));
        if (!$jobs) {
            $io->text('Jobs list is empty');
            return 0;
        }
        foreach ($jobs as $job) {
            $io->text($job);
        }
        return 0;
    }
}