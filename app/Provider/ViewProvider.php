<?php

namespace App\Provider;

use App\Api\Render\RenderInterface;
use App\Service\View\RenderView\RenderView;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ViewProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {
        $container['view'] = function (Container $container) {
            /** @var RenderInterface $render */
            $render = $container['render.web'];
            $view = new RenderView($render);
            return $view;
        };
    }
}