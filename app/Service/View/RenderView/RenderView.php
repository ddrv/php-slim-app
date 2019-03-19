<?php

namespace App\Service\View\RenderView;

use App\Api\Render\RenderInterface;
use App\Api\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;

class RenderView implements ViewInterface
{

    /**
     * @var RenderInterface
     */
    protected $render;

    protected $data = [];

    public function __construct(RenderInterface $render, $data = [])
    {
        $this->render = $render;
        $this->data = (array)$data;
    }

    public function view(ResponseInterface $response, $template, $data = [])
    {
        if ($this->data) $data = array_replace_recursive($this->data, (array)$data);
        $body = $response->getBody();
        $body->write($this->render->render($template, $data));
        return $response;
    }
}