Legatus Http Errors
===================

HTTP exceptions for PSR-7 applications

[![Build Status](https://drone.mnavarro.dev/api/badges/legatus/http-errors/status.svg)](https://drone.mnavarro.dev/legatus/http-errors)

## Installation
You can install the Http Errors component using [Composer][composer]:

```bash
composer require legatus/http-errors
```

## Quick Start

```php
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
```

For more details you can check the [online documentation here][docs].

## Community
We still do not have a community channel. If you would like to help with that, you can let me know!

## Contributing
Read the contributing guide to know how can you contribute to Quilt.

## Security Issues
Please report security issues privately by email and give us a period of grace before disclosing.

## About Legatus
Legatus is a personal open source project led by Matías Navarro Carter and developed by contributors.

[composer]: https://getcomposer.org/
[docs]: https://legatus.mnavarro.dev/components/http-errors