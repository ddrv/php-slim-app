<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Slim\Container;

class CliAppBootstrap implements BootstrapInterface
{
    /**
     * @param Container $container
     */
    public function boot($container)
    {
        $container['cli'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $app = new Application();
            $app->add($container->get('cli.hello'));
            return $app;
        };
    }
}