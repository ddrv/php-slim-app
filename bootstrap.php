<?php

$autoloader = require(__DIR__.'/vendor/autoload.php');

use Slim\App;
use Symfony\Component\Console\Application;
use Psr\Container\ContainerInterface;
use App\BootstrapInterface;

$config = require (__DIR__.'/config/global.php');
$localConfigFile = __DIR__.'/config/local.php';
if (is_readable($localConfigFile)) {
    $local = include ($localConfigFile);
    $config = array_replace_recursive($config, $local);
}

$container = new \Slim\Container($config);

foreach ($config['bootstrap'] as $bootstrap) {
    $boot = new $bootstrap();
    if ($boot instanceof BootstrapInterface) {
        $boot->boot($container);
    }
}

$container['web'] = function ($container) {
    $app = new App($container);

    $app->group('/', function () use ($app) {
        $app->get('{name}', 'web.page:hello')->setName('hello')->add('mw.log');
        $app->get('', 'web.page:main')->setName('main');
    });

    return $app;

};

$container['cli'] = function ($container) {
    /**
     * @var ContainerInterface $container
     */
    $app = new Application();
    $app->add($container->get('cli.hello'));
    return $app;
};

return $container;