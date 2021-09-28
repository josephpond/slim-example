<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class AuthenticationMiddleware implements MiddlewareInterface
{
    // sha1 of 'testkey'.
    private const KEY = '913a73b565c8e2c8ed94497580f619397709b8b6';

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws HttpUnauthorizedException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = $request->getQueryParams();
        if (array_key_exists('key', $params) && sha1($params['key']) === self::KEY) {
            return $handler->handle($request);
        }
        throw new HttpUnauthorizedException($request, 'Not Authorized');
    }
}
