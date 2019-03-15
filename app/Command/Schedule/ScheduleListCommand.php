<?php

namespace App\Command\Schedule;

use App\Api\Schedule\ScheduleInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ScheduleListCommand extends Command
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
            ->setDescription('List of Schedule.')
            ->setHelp('List of Schedule.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('schedule');
        $rows = [];
        $jobs = $this->schedule->getJobs();
        if (!$jobs) {
            $io->text('Jobs list is empty');
            return 0;
        }
        foreach ($jobs as $job) {
            $rows[] = [
                $job->getExpression(),
                $job->getCommand(),
            ];
        }
        $io->table(
            ['Expression', 'Command'],
            $rows
        );
        return 0;
    }
}