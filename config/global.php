<?php

$root = dirname(__DIR__);

return [
    'providers' => [
        \App\Provider\CommandsProvider::class,
        \App\Provider\RenderProvider::class,
        \App\Provider\LoggerProvider::class,
        \App\Provider\ViewProvider::class,
        \App\Provider\WebProvider::class,
    ],
    'slim.settings' => [
        'debug'               => true,
        'displayErrorDetails' => true,
    ],
    'site' => [
        'host' => 'localhost',
    ],
    'fs' => [
        'public' => implode(DIRECTORY_SEPARATOR, [$root, 'public']),
        'entry' => implode(DIRECTORY_SEPARATOR, [$root, 'public', 'index.php']),
        'exec' => '/usr/bin/php ' . implode(DIRECTORY_SEPARATOR, [$root, 'bin', 'console']),
        'logs' => implode(DIRECTORY_SEPARATOR, [$root, 'var', 'logs']),
    ],
    'render.web' => [
        'render' => 'twig',
        'twig.templates' => implode(DIRECTORY_SEPARATOR, [$root, 'templates', 'twig', 'web']),
        'twig.options.cache' => implode(DIRECTORY_SEPARATOR, [$root, 'var', 'cache', 'templates', 'twig', 'web']),
        'twig.options.debug' => false,
    ],
    'schedule' => [
        /*
        [
            'expression' => '* * * * *',
            'command' => 'console:command argument1 argument2',
            'options' => [
                'some-option' => 'some-value'
            ],
        ],
        /**/
    ],

];