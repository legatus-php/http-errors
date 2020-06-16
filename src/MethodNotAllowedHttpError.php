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
 * Class MethodNotAllowedHttpError.
 */
class MethodNotAllowedHttpError extends HttpError
{
    /**
     * @var string[]
     */
    private array $allowedMethods;

    /**
     * MethodNotAllowedHttpError constructor.
     *
     * @param Request        $request
     * @param string[]       $allowedMethods
     * @param string|null    $message
     * @param Throwable|null $previous
     */
    public function __construct(Request $request, array $allowedMethods, string $message = null, Throwable $previous = null)
    {
        parent::__construct($request, ErrorCodes::METHOD_NOT_ALLOWED, $message, $previous);
        $this->allowedMethods = $allowedMethods;
    }

    /**
     * @return string[]
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['allowedMethods'] = $this->allowedMethods;

        return $data;
    }
}
