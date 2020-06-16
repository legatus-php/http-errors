<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Next;

/**
 * Class SomeAuthorizationMiddleware
 */
class SomeAuthorizationMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Next $next): Response
    {
        if (!$this->isAuthorized($request)) {
            // Throw the exception and handle it in an upstream middleware
            throw Legatus\Http\Errors\make_for($request)->unauthorized();

            // You can also use the traditional form:
            // throw new Legatus\Http\Errors\UnauthorizedHttpError($request);
        }

        return $next->handle($request);
    }
}