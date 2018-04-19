<?php

return [
    'settings' => [
        'displayErrorDetails' => false,
        'addContentLengthHeader' => true,
        'debug' => false,
        'path' => [
            'base' => dirname(__DIR__),
            'views' => dirname(__DIR__).'/resources/views',
            'cache' => dirname(__DIR__).'/storage/cache',
            'logs' => dirname(__DIR__).'/storage/logs',
            'command' => dirname(__DIR__).'/bin/command',
            'php' => '/usr/bin/php',
        ],
    ],
    'bootstrap' => [
        \App\Bootstrap\BaseBootstrap::class,
        \App\Bootstrap\TwigRender::class,
        \App\Bootstrap\UriGeneratorBootstrap::class,
        \App\Bootstrap\CommandGeneratorBootstrap::class,
    ],
];