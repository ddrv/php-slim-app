<?php

namespace App\Command\App;

use Slim\Router;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
{

    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     * @param string $name
     */
    public function __construct(Router $router, $name)
    {
        $this->router = $router;
        $this->setName($name);
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Hello command')
            ->setHelp('This command output hello phrase')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello!');
        $output->writeln('Hello page: '.$this->router->pathFor('hello', ['name'=>'bro']));
    }
}