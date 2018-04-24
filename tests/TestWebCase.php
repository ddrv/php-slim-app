<?php

namespace Tests\App;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

/**
 * Class TestCase
 */
abstract class TestWebCase extends TestCase
{

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function connect($uri, $body='', $headers=[])
    {
        return $this->request('CONNECT', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function delete($uri, $body='', $headers=[])
    {
        return $this->request('DELETE', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function get($uri, $body='', $headers=[])
    {
        return $this->request('GET', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function head($uri, $body='', $headers=[])
    {
        return $this->request('HEAD', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function options($uri, $body='', $headers=[])
    {
        return $this->request('OPTIONS', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function patch($uri, $body='', $headers=[])
    {
        return $this->request('PATCH', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function post($uri, $body='', $headers=[])
    {
        return $this->request('POST', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function put($uri, $body='', $headers=[]) {
        return $this->request('PUT', $uri, $body, $headers);
    }

    /**
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function trace($uri, $body='', $headers=[])
    {
        return $this->request('TRACE', $uri, $body, $headers);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function request($method, $uri, $body='', $headers=[])
    {
        $server = $this->getGlobalsServer($method, $uri, $body, $headers);
        return $this->runApp($server, $body);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return array
     */

    protected function getGlobalsServer($method, $uri, $body='', $headers=[])
    {
        $server = [
            'REQUEST_METHOD' => $method,
            'REQUEST_URI'    => $uri,
        ];
        foreach ($headers as $header=>$value) {
            $key = mb_strtoupper($header);
            $key = str_replace('-', '_', $key);
            $key = 'HTTP_'.$key;
            $server[$key] = $value;
        }
        return $server;
    }

    /**
     * @param array $server
     * @param string $content
     * @return ResponseInterface
     */
    protected function runApp($server, $content)
    {
        $env = Environment::mock($server);
        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $body = new RequestBody();
        $body->write($content);
        $request  = new Request($server['REQUEST_METHOD'], $uri, $headers, [], $server, $body);
        $response = new Response();
        $container = require (__DIR__.'/../bootstrap.php');
        return $container->get('web')->process($request, $response);
    }
}