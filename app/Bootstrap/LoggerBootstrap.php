<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use Psr\Container\ContainerInterface;
use Analog\Logger;
use Analog\Analog;
use Analog\Handler\File;
use Slim\Container;

class LoggerBootstrap implements BootstrapInterface
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
            $logger = new Logger();
            Analog::$date_format = 'H:i:s';
            $id = $this->generateRequestId();
            $logger->format('['.$id.' %s %s %d] %s'.PHP_EOL);
            $logger->handler(File::init ($log));
            return $logger;
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