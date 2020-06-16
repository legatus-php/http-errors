<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http\Errors\Tests;

use Legatus\Http\Errors\HttpError;
use function Legatus\Http\Errors\make_for;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class HttpExceptionTest.
 */
class HttpExceptionTest extends TestCase
{
    public function testItThrowsExceptionOnInvalidCode(): void
    {
        $uriMock = $this->createMock(UriInterface::class);
        $requestMock = $this->createMock(ServerRequestInterface::class);

        $requestMock->expects($this->atLeastOnce())
            ->method('getUri')
            ->willReturn($uriMock);
        $requestMock->expects($this->atLeastOnce())
            ->method('getMethod')
            ->willReturn('GET');
        $uriMock->expects($this->atLeastOnce())
            ->method('getPath')
            ->willReturn('/some/path');

        $this->expectException(\InvalidArgumentException::class);
        new HttpError($requestMock, 300);
    }

    public function testItCreatesErrorsCorrectly(): void
    {
        $uriMock = $this->createMock(UriInterface::class);
        $requestMock = $this->createMock(ServerRequestInterface::class);

        $requestMock->expects($this->atLeastOnce())
            ->method('getUri')
            ->willReturn($uriMock);
        $requestMock->expects($this->atLeastOnce())
            ->method('getMethod')
            ->willReturn('GET');
        $uriMock->expects($this->atLeastOnce())
            ->method('getPath')
            ->willReturn('/some/path');

        $e = make_for($requestMock)->badRequest();
        $this->assertEquals(400, $e->getCode());
        $this->assertTrue($e->isClient());
        $this->assertFalse($e->isServer());
        $this->assertSame('Cannot GET /some/path', $e->getMessage());
        $this->assertSame($requestMock, $e->getRequest());
        $this->assertTrue($e->isCode(400));
        $this->assertSame([
            'status' => 400,
            'message' => 'Cannot GET /some/path',
        ], $e->toArray());

        $e = make_for($requestMock)->unauthorized();
        $this->assertEquals(401, $e->getCode());

        $e = make_for($requestMock)->forbidden();
        $this->assertEquals(403, $e->getCode());

        $e = make_for($requestMock)->notFound();
        $this->assertEquals(404, $e->getCode());

        $e = make_for($requestMock)->methodNotAllowed(['PUT', 'POST']);
        $this->assertEquals(405, $e->getCode());
        $this->assertSame(['PUT', 'POST'], $e->getAllowedMethods());
        $this->assertSame([
            'status' => 405,
            'message' => 'Cannot GET /some/path',
            'allowedMethods' => ['PUT', 'POST'],
        ], $e->toArray());

        $e = make_for($requestMock)->notAcceptable();
        $this->assertEquals(406, $e->getCode());

        $e = make_for($requestMock)->conflict();
        $this->assertEquals(409, $e->getCode());

        $e = make_for($requestMock)->gone();
        $this->assertEquals(410, $e->getCode());

        $e = make_for($requestMock)->lengthRequired();
        $this->assertEquals(411, $e->getCode());

        $e = make_for($requestMock)->preconditionFailed();
        $this->assertEquals(412, $e->getCode());

        $e = make_for($requestMock)->payloadTooLarge();
        $this->assertEquals(413, $e->getCode());

        $e = make_for($requestMock)->unsupportedMediaType();
        $this->assertEquals(415, $e->getCode());

        $e = make_for($requestMock)->unprocessableEntity();
        $this->assertEquals(422, $e->getCode());

        $e = make_for($requestMock)->tooManyRequests();
        $this->assertEquals(429, $e->getCode());

        $e = make_for($requestMock)->internalServerError();
        $this->assertEquals(500, $e->getCode());
        $this->assertTrue($e->isServer());
        $this->assertFalse($e->isClient());

        $e = make_for($requestMock)->notImplemented();
        $this->assertEquals(501, $e->getCode());

        $e = make_for($requestMock)->serviceUnavailable();
        $this->assertEquals(503, $e->getCode());
    }
}
