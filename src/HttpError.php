<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http\Errors;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;
use Throwable;

/**
 * Class HttpError.
 *
 * The de-facto exception for your PSR-7 HTTP layer
 */
class HttpError extends RuntimeException
{
    private Request $request;

    /**
     * HttpError constructor.
     *
     * @param Request        $request
     * @param int            $statusCode
     * @param string         $message
     * @param Throwable|null $previous
     */
    public function __construct(Request $request, int $statusCode, string $message = null, Throwable $previous = null)
    {
        $message = $message ?? $this->createStandardMessageFrom($request);
        parent::__construct($message, $statusCode, $previous);
        $this->request = $request;
        $this->guardCode();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->code >= 400 && $this->code < 500;
    }

    /**
     * @param int $code
     *
     * @return bool
     */
    public function isCode(int $code): bool
    {
        return $this->code === $code;
    }

    /**
     * @return bool
     */
    public function isServer(): bool
    {
        return $this->code >= 500 && $this->code < 600;
    }

    private function guardCode(): void
    {
        if ($this->code < 400 || $this->code >= 600) {
            throw new InvalidArgumentException('Error status code is not in the 400 or 500 range');
        }
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    protected function createStandardMessageFrom(Request $request): string
    {
        return sprintf('Cannot %s %s', $request->getMethod(), $request->getUri()->getPath());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status' => $this->code,
            'message' => $this->message,
        ];
    }
}
