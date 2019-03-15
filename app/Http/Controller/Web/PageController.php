<?php

namespace App\Http\Controller\Web;

use App\Api\Render\RenderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageController
{

    /**
     * @var RenderInterface
     */
    protected $render;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @param RenderInterface $render
     */
    public function __construct(RenderInterface $render)
    {
        $this->render = $render;
    }

    public function main(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        unset($args, $request);
        return $this->render->view($response, 'page/main', [
            'command' => 'app:hello',
        ]);
    }

    public function hello(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        unset($request);
        return $this->render->view($response, 'page/hello', [
            'name' => $args['name'],
        ]);
    }
}