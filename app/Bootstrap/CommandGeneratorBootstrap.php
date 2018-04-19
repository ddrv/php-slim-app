<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use App\Services\CommandGenerator;
use Psr\Container\ContainerInterface;
use Slim\Container;


class CommandGeneratorBootstrap implements BootstrapInterface
{
    /**
     * @param Container $container
     */
    public function boot($container)
    {
        $container['commandGenerator'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $cli = $container->get('cli');
            $settings = $container->get('settings');
            return new CommandGenerator($settings['path']['php'], $settings['path']['command'], $cli);
        };
    }
}