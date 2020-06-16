<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http\Errors;

use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

/**
 * Class NotImplementedHttpError.
 */
class NotImplementedHttpError extends HttpError
{
    public function __construct(Request $request, string $message = null, Throwable $previous = null)
    {
        parent::__construct($request, ErrorCodes::NOT_IMPLEMENTED, $message, $previous);
    }
}
