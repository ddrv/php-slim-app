<?php

namespace App\Services;

use Slim\Router;

/**
 * Class UriGenerator
 *
 * @property Router $router
 */
class UriGenerator
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * UriGenerator constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function createUri($name, $arguments=[])
    {
        return $this->router->pathFor($name, $arguments);
    }
}