<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class LogMiddleware
 *
 * @property LoggerInterface $logger
 */
class LogMiddleware
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * LogMW constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->logger->info($request->getUri());
        $response = $next($request, $response);
        /**
         * @var ResponseInterface $response
         */
        $this->logger->info($response->getStatusCode().' '.$response->getReasonPhrase());
        return $response;
    }
}