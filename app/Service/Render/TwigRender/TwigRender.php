<?php

namespace App\Service\Render\TwigRender;


use App\Api\Render\RenderInterface;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;
use Exception;

class TwigRender implements RenderInterface
{

    protected $render;

    protected $data = [];

    public function __construct(Environment $render, $data = [])
    {
        $this->render = $render;
        $this->data = $data;
    }

    public function render($template, $data = [])
    {
        $data = array_replace_recursive($this->data, $data);
        if (!preg_match('/\.twig$/ui', $template)) {
            $template .= '.twig';
        }
        try {
            $out = $this->render->render($template, $data);
        } catch (Exception $e) {
            $out = null;
        }
        return $out;
    }

    public function view(ResponseInterface $response, $template, $data = [])
    {
        $body = $response->getBody();
        $body->write($this->render($template, $data));
        return $response;
    }
}