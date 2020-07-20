<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http;

use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

/**
 * Class MethodNotAllowed.
 */
class MethodNotAllowed extends HttpError
{
    private const CODE = 405;

    /**
     * @var string[]
     */
    private array $allowedMethods;

    /**
     * @return int
     */
    public static function statusCode(): int
    {
        return self::CODE;
    }

    /**
     * MethodNotAllowed constructor.
     *
     * @param Request        $request
     * @param string[]       $allowedMethods
     * @param string|null    $message
     * @param Throwable|null $previous
     */
    public function __construct(Request $request, array $allowedMethods, string $message = null, Throwable $previous = null)
    {
        parent::__construct($request, $message, $previous);
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
