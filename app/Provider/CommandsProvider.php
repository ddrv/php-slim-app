<?php

namespace App\Provider;

use App\Command\HelloCommand;
use App\Command\Schedule\ScheduleListCommand;
use App\Command\Schedule\ScheduleRunCommand;
use App\Service\Schedule\Schedule;
use App\Support\CommandLoader;
use App\Support\Background;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\Router;
use Symfony\Component\Console\Application;

class CommandsProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {

        $container['support.background'] = function (Container $container) {
            $config = $container['config'];
            $exec = $config['fs']['exec'];
            $background = new Background($exec);
            return $background;
        };

        $container['service.schedule'] = function (Container $container) {
            $config = $container['config'];
            $background = $container['support.background'];
            $schedule = new Schedule($background, $config['schedule']);
            return $schedule;
        };

        $container['cli.app:hello'] = function (Container $container) {
            /**
             * @var Router $router
             */
            $router = $container['router'];
            return new HelloCommand($router, 'app:hello');
        };

        $container['cli.schedule:run'] = function (Container $container) {
            return new ScheduleRunCommand($container['service.schedule'], 'schedule:run');
        };

        $container['cli.schedule:list'] = function (Container $container) {
            return new ScheduleListCommand($container['service.schedule'], 'schedule:list');
        };

        $container['cli'] = function (Container $container) {
            $app = new Application();
            $loader = new CommandLoader($container);
            $app->setCommandLoader($loader);
            return $app;
        };
    }
}