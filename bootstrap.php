<?php

$autoloader = require(__DIR__.'/vendor/autoload.php');

use App\BootstrapInterface;
use Slim\Container;

$environment = file_exists(__DIR__.'/.environment')?(trim(file_get_contents(__DIR__.'/.environment'))):'local';

$config = require (__DIR__.'/config/global.php');
$envConfigFile = __DIR__.'/config/'.$environment.'.php';
if (is_readable($envConfigFile)) {
    $envConfig = include ($envConfigFile);
    $config = array_replace_recursive($config, $envConfig);
}

$container = new Container($config);

foreach ($config['bootstrap'] as $bootstrap) {
    $boot = new $bootstrap();
    if ($boot instanceof BootstrapInterface) {
        $boot->boot($container);
    }
}

return $container;