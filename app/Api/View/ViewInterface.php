<?php

namespace App\Api\View;

use Psr\Http\Message\ResponseInterface;

interface ViewInterface
{

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    public function view(ResponseInterface $response, $template, $data = []);
}