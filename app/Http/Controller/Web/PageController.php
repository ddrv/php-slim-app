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

    public function home(ServerRequestInterface $request, ResponseInterface $response)
    {
        unset($request);
        return $this->render->view($response, 'page/main', [
            'command' => 'php ./bin/console app:hello',
        ]);
    }

    public function hello(ServerRequestInterface $request, ResponseInterface $response)
    {
        $name = $request->getAttribute('name');
        return $this->render->view($response, 'page/hello', [
            'name' => $name,
        ]);
    }
}