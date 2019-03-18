<?php

namespace App\Api\Render;

use Psr\Http\Message\ResponseInterface;

interface RenderInterface
{

    /**
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public function render($template, $data = []);

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public function view(ResponseInterface $response, $template, $data = []);
}