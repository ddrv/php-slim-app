<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use App\Services\UriGenerator;
use Psr\Container\ContainerInterface;
use Slim\Container;


class UriGeneratorBootstrap implements BootstrapInterface
{
    /**
     * @param Container $container
     */
    public function boot($container)
    {
        $container['uriGenerator'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $router = $container->get('web')->getContainer()->get('router');
            return new UriGenerator($router);
        };
    }
}