<?php

namespace App\Commands;

use App\Services\UriGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class HelloCommand
 * @property UriGenerator $uriGenerator
 */
class HelloCommand extends Command
{

    /**
     * @var UriGenerator
     */
    protected $uriGenerator;

    /**
     * HelloCommand constructor.
     * @param UriGenerator $uriGenerator
     */
    public function __construct(UriGenerator $uriGenerator)
    {
        $this->uriGenerator = $uriGenerator;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('hello')
            ->setDescription('Hello command')
            ->setHelp('This command output hello phrase')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello!');
        $output->writeln('Hello page: '.$this->uriGenerator->createUri('hello', ['name'=>'bro']));
    }
}