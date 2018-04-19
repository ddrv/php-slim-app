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
        $container['logger'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $settings = $container->get('settings');
            $log = $settings['path']['logs'].'/'.date('Y-m-d').'.log';
            $logger = new Logger;
            Analog::$date_format = 'H:i:s';
            $id = $this->generateRequestId();
            $logger->format('['.$id.' %s %s %d] %s'.PHP_EOL);
            $logger->handler(File::init ($log));
            return $logger;
        };

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

    /**
     * @param integer $len
     * @param string $symbols
     * @return string
     */
    protected function generateRequestId($len=5, $symbols='')
    {
        if (!$symbols) $symbols = 'QWERTYUIOPASDFGHJKLZXCVBNM01234567890';
        $id = '';
        $max = mb_strlen($symbols) - 1;
        for ($i = 0; $i < $len; $i++) {
            $id .= mb_substr($symbols, rand(0,$max), 1);
        }
        return $id;
    }
}