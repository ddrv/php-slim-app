<?php

$container = require(__DIR__.'/../bootstrap.php');
$container->get('web')->run();