<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use Psr\Container\ContainerInterface;
use Slim\Views\TwigExtension;
use App\Services\Twig;

class TwigRender implements BootstrapInterface
{
    public function boot($container)
    {
        $container['render'] = function ($container) {
            /**
             * @var ContainerInterface $container
             */
            $settings = $container->get('settings');

            $twigConfig = [];
            if (empty($settings['debug'])) {
                $twigConfig['cache'] = $settings['path']['cache'].'/twig';
            }
            $render = new Twig($settings['path']['views'], $twigConfig);

            $render->addExtension(new TwigExtension($container['router'], $settings['path']['base']));

            return $render;

        };
    }
}