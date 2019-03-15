<?php

namespace App\Provider;

use App\Service\Render\TwigRender\TwigRender;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RenderProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {
        $container['render.web'] = function (Container $container) {
            $config = $container['config'];
            $loader = new FilesystemLoader($config['render.web']['twig.templates']);
            $options = [
                'cache' => $config['render.web']['twig.options.cache'],
                'debug' => $config['render.web']['twig.options.debug'],
            ];
            $twig = new Environment($loader, $options);
            $render = new TwigRender($twig);
            return $render;
        };
    }
}