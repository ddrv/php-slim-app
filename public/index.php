<?php

$container = require(__DIR__ . '/../bootstrap.php');

/**
 * @var \Slim\App $app
 */
$app = $container['web'];
$app->run();