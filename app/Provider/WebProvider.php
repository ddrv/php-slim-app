<?php

namespace App\Provider;

use App\Http\Controller\Web\PageController;
use App\Http\Middleware\LogMiddleware;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Log\LoggerInterface;
use Slim\App;

class WebProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {
        $container['web.controller.page'] = function (Container $container) {
            /** @var Container $container */
            $render = $container['render.web'];
            return new PageController($render);
        };

        $container['web.middleware.log'] = function (Container $container) {
            /**
             * @var Container $container
             * @var LoggerInterface $logger
             */
            $logger = $container['logger'];
            return new LogMiddleware($logger);
        };

        $container['web'] = function (Container $container) {
            $app = new App($container);
            $app->group('/', function () use ($app) {
                $app->get('{name}', 'web.controller.page:hello')->setName('hello')->add('web.middleware.log');
                $app->get('', 'web.controller.page:home')->setName('home');
            });
            return $app;
        };
    }
}