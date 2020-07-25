<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;
use Throwable;

/**
 * Class HttpError.
 *
 * The de-facto exception for your PSR-7 HTTP layer
 */
abstract class HttpError extends RuntimeException
{
    private Request $request;
    private array $meta;

    /**
     * @return int
     */
    abstract public static function statusCode(): int;

    /**
     * HttpError constructor.
     *
     * @param Request        $request
     * @param string         $message
     * @param Throwable|null $previous
     */
    public function __construct(Request $request, string $message = null, Throwable $previous = null)
    {
        $message = $message ?? $this->createStandardMessageFrom($request);
        parent::__construct($message, static::statusCode(), $previous);
        $this->request = $request;
        $this->meta = [];
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
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasMeta(string $key): bool
    {
        return array_key_exists($key, $this->meta);
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return HttpError
     */
    public function addMeta(string $key, $value): HttpError
    {
        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function readMeta(string $key)
    {
        return $this->meta[$key] ?? null;
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
        ] + $this->meta;
    }
}
