<?php

namespace App;

use Psr\Http\Message\ResponseInterface;

interface RenderInterface
{
    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, $data);
}