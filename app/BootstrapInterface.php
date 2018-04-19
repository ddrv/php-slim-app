<?php

namespace App;

use Slim\Container;

interface BootstrapInterface
{
    /**
     * @param Container $container
     * @return Container
     */
    public function boot($container);
}