<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use App\Controllers\Web\PageController;
use App\Middleware\LogMiddleware;
use Psr\Container\ContainerInterface;
use Analog\Logger;
use Analog\Analog;
use Analog\Handler\File;
use Slim\Container;
use App\Commands\HelloCommand;

class BaseBootstrap implements BootstrapInterface
{
    /**
     * @param Container $container
     */
    public function boot($container)
    {
        $container['web.page'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $render = $container->get('render');
            $commandGenerator = $container->get('commandGenerator');
            $settings = $container->get('settings');
            return new PageController($render, $commandGenerator, $settings);
        };

        $container['cli.hello'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $uriGenerator = $container->get('uriGenerator');
            return new HelloCommand($uriGenerator);
        };

        $container['mw.log'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $logger = $container->get('logger');
            return new LogMiddleware($logger);
        };
    }
}