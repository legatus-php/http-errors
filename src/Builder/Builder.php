<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http\Errors\Builder;

use Legatus\Http\Errors;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

/**
 * Class Builder.
 */
class Builder
{
    private Request $request;

    /**
     * Builder constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\BadRequestHttpError
     */
    public function badRequest(string $message = null, Throwable $previous = null): Errors\BadRequestHttpError
    {
        return new Errors\BadRequestHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\ConflictHttpError
     */
    public function conflict(string $message = null, Throwable $previous = null): Errors\ConflictHttpError
    {
        return new Errors\ConflictHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\ForbiddenHttpError
     */
    public function forbidden(string $message = null, Throwable $previous = null): Errors\ForbiddenHttpError
    {
        return new Errors\ForbiddenHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\GoneHttpError
     */
    public function gone(string $message = null, Throwable $previous = null): Errors\GoneHttpError
    {
        return new Errors\GoneHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\InternalServerErrorHttpError
     */
    public function internalServerError(string $message = null, Throwable $previous = null): Errors\InternalServerErrorHttpError
    {
        return new Errors\InternalServerErrorHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\LengthRequiredHttpError
     */
    public function lengthRequired(string $message = null, Throwable $previous = null): Errors\LengthRequiredHttpError
    {
        return new Errors\LengthRequiredHttpError($this->request, $message, $previous);
    }

    /**
     * @param array          $allowedMethods
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\MethodNotAllowedHttpError
     */
    public function methodNotAllowed(array $allowedMethods, string $message = null, Throwable $previous = null): Errors\MethodNotAllowedHttpError
    {
        return new Errors\MethodNotAllowedHttpError($this->request, $allowedMethods, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\NotAcceptableHttpError
     */
    public function notAcceptable(string $message = null, Throwable $previous = null): Errors\NotAcceptableHttpError
    {
        return new Errors\NotAcceptableHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\NotFoundHttpError
     */
    public function notFound(string $message = null, Throwable $previous = null): Errors\NotFoundHttpError
    {
        return new Errors\NotFoundHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\NotImplementedHttpError
     */
    public function notImplemented(string $message = null, Throwable $previous = null): Errors\NotImplementedHttpError
    {
        return new Errors\NotImplementedHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\PayloadTooLargeHttpError
     */
    public function payloadTooLarge(string $message = null, Throwable $previous = null): Errors\PayloadTooLargeHttpError
    {
        return new Errors\PayloadTooLargeHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\PreconditionFailedHttpError
     */
    public function preconditionFailed(string $message = null, Throwable $previous = null): Errors\PreconditionFailedHttpError
    {
        return new Errors\PreconditionFailedHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\ServiceUnavailableHttpError
     */
    public function serviceUnavailable(string $message = null, Throwable $previous = null): Errors\ServiceUnavailableHttpError
    {
        return new Errors\ServiceUnavailableHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\TooManyRequestsHttpError
     */
    public function tooManyRequests(string $message = null, Throwable $previous = null): Errors\TooManyRequestsHttpError
    {
        return new Errors\TooManyRequestsHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\UnauthorizedHttpError
     */
    public function unauthorized(string $message = null, Throwable $previous = null): Errors\UnauthorizedHttpError
    {
        return new Errors\UnauthorizedHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\UnprocessableEntityHttpError
     */
    public function unprocessableEntity(string $message = null, Throwable $previous = null): Errors\UnprocessableEntityHttpError
    {
        return new Errors\UnprocessableEntityHttpError($this->request, $message, $previous);
    }

    /**
     * @param string|null    $message
     * @param Throwable|null $previous
     *
     * @return Errors\UnsupportedMediaTypeHttpError
     */
    public function unsupportedMediaType(string $message = null, Throwable $previous = null): Errors\UnsupportedMediaTypeHttpError
    {
        return new Errors\UnsupportedMediaTypeHttpError($this->request, $message, $previous);
    }
}
