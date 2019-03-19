<?php

namespace App\Service\Render\TwigRender;


use App\Api\Render\RenderInterface;
use Twig\Environment;
use Exception;

class TwigRender implements RenderInterface
{

    protected $render;

    protected $data = [];

    public function __construct(Environment $render, $data = [])
    {
        $this->render = $render;
        $this->data = (array)$data;
    }

    public function render($template, $data = [])
    {
        if ($this->data) $data = array_replace_recursive($this->data, (array)$data);
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
}