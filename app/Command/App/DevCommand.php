<?php

namespace App\Command\App;

use App\Command\IOStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class DevCommand extends Command
{

    private $php;

    private $entry;

    /**
     * @param string $entry
     * @param string $name
     */
    public function __construct($entry, $name)
    {
        $phpBinaryFinder = new PhpExecutableFinder();
        $this->php = $phpBinaryFinder->find();
        $this->entry = $entry;
        $this->setName($name);
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Run http server (only for development)')
            ->setHelp('Run http server (only for development)')
            ->addArgument('port', InputArgument::OPTIONAL, 'port', 8080);
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new IOStyle($input, $output);
        $port = (int)$input->getArgument('port');
        $command = $this->php.' -S localhost:'.$port.' -t public '.$this->entry;
        $process = new Process($command);
        $process->enableOutput();
        $process->start();
        $process->setTimeout(false);
        $io->title('Development Server started on http://localhost:' . $port.' pid:'.$process->getPid());
        $process->wait(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }
}