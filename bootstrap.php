<?php

require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$env = getenv('APP_ENV');
if (!$env) $env = 'local';
$config = require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'global.php';
$envConfigFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $env . '.php';
/** @noinspection PhpIncludeInspection */
$envConfig = file_exists($envConfigFile)?require($envConfigFile): [];
$config = array_replace_recursive($config, $envConfig);

$settings = $config['slim.settings'];
unset($config['slim.settings']);

$container = new \Slim\Container([
    'settings' => $settings,
    'config' => $config,
]);

foreach ($config['providers'] as $className) {
    if (!class_exists($className)) {
        /** @noinspection PhpUnhandledExceptionInspection */
        throw new Exception('Provider ' . $className . ' not found');
    }
    $provider = new $className;
    $container->register(new $provider);
}

$container['web'];

return $container;