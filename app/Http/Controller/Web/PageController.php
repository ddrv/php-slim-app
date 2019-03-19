<?php

namespace App\Http\Controller\Web;

use App\Api\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageController
{

    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @param ViewInterface $view
     */
    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response)
    {
        unset($request);
        return $this->view->view($response, 'page/main', [
            'command' => 'php ./bin/console app:hello',
        ]);
    }

    public function hello(ServerRequestInterface $request, ResponseInterface $response)
    {
        $name = $request->getAttribute('name');
        return $this->view->view($response, 'page/hello', [
            'name' => $name,
        ]);
    }
}