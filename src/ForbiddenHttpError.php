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
 * Class ForbiddenHttpError.
 */
class ForbiddenHttpError extends HttpError
{
    /**
     * ForbiddenHttpError constructor.
     *
     * @param Request        $request
     * @param string|null    $message
     * @param Throwable|null $previous
     */
    public function __construct(Request $request, string $message = null, Throwable $previous = null)
    {
        parent::__construct($request, ErrorCodes::FORBIDDEN, $message, $previous);
    }
}
