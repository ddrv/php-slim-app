<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use Slim\App;
use Slim\Container;

class WebAppBootstrap implements BootstrapInterface
{
    /**
     * @param Container $container
     */
    public function boot($container)
    {
        $container['web'] = function ($container) {
            $app = new App($container);

            $app->group('/', function () use ($app) {
                $app->get('{name}', 'web.page:hello')->setName('hello')->add('mw.log');
                $app->get('', 'web.page:main')->setName('main');
            });

            return $app;

        };
    }
}