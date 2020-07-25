<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class HttpExceptionTest.
 */
class HttpExceptionTest extends TestCase
{
    public function testItCreatesErrorsCorrectly(): void
    {
        $uriMock = $this->createMock(UriInterface::class);
        $requestMock = $this->createMock(ServerRequestInterface::class);

        $requestMock->expects(self::atLeastOnce())
            ->method('getUri')
            ->willReturn($uriMock);
        $requestMock->expects(self::atLeastOnce())
            ->method('getMethod')
            ->willReturn('GET');
        $uriMock->expects(self::atLeastOnce())
            ->method('getPath')
            ->willReturn('/some/path');

        $e = new BadRequest($requestMock);
        self::assertEquals(400, $e->getCode());
        self::assertTrue($e->isClient());
        self::assertFalse($e->isServer());
        self::assertSame('Cannot GET /some/path', $e->getMessage());
        self::assertSame($requestMock, $e->getRequest());
        self::assertTrue($e->isCode(400));
        self::assertSame([
            'status' => 400,
            'message' => 'Cannot GET /some/path',
        ], $e->toArray());

        $e = new Unauthorized($requestMock);
        self::assertEquals(401, $e->getCode());

        $e = new Forbidden($requestMock);
        self::assertEquals(403, $e->getCode());

        $e = new NotFound($requestMock);
        self::assertEquals(404, $e->getCode());

        $e = new MethodNotAllowed($requestMock, ['PUT', 'POST']);
        self::assertEquals(405, $e->getCode());
        self::assertSame(['PUT', 'POST'], $e->getAllowedMethods());
        self::assertSame([
            'status' => 405,
            'message' => 'Cannot GET /some/path',
            'allowedMethods' => ['PUT', 'POST'],
        ], $e->toArray());

        $e = new NotAcceptable($requestMock);
        self::assertEquals(406, $e->getCode());

        $e = new Conflict($requestMock);
        self::assertEquals(409, $e->getCode());

        $e = new Gone($requestMock);
        self::assertEquals(410, $e->getCode());

        $e = new LengthRequired($requestMock);
        self::assertEquals(411, $e->getCode());

        $e = new PreconditionFailed($requestMock);
        self::assertEquals(412, $e->getCode());

        $e = new PayloadTooLarge($requestMock);
        self::assertEquals(413, $e->getCode());

        $e = new UnsupportedMediaType($requestMock);
        self::assertEquals(415, $e->getCode());

        $e = new UnprocessableEntity($requestMock);
        self::assertEquals(422, $e->getCode());

        $e = new TooManyRequests($requestMock);
        self::assertEquals(429, $e->getCode());

        $e = new InternalServerError($requestMock);
        self::assertEquals(500, $e->getCode());
        self::assertTrue($e->isServer());
        self::assertFalse($e->isClient());

        $e = new NotImplemented($requestMock);
        self::assertEquals(501, $e->getCode());

        $e = new ServiceUnavailable($requestMock);
        self::assertEquals(503, $e->getCode());
    }

    public function testItSetsAndGetsMetadata(): void
    {
        $uriMock = $this->createMock(UriInterface::class);
        $requestMock = $this->createMock(ServerRequestInterface::class);

        $requestMock->expects(self::atLeastOnce())
            ->method('getUri')
            ->willReturn($uriMock);
        $requestMock->expects(self::atLeastOnce())
            ->method('getMethod')
            ->willReturn('GET');
        $uriMock->expects(self::atLeastOnce())
            ->method('getPath')
            ->willReturn('/some/path');

        $e = new TooManyRequests($requestMock);
        $e->addMeta('wait', 3600);
        self::assertSame(['wait' => 3600], $e->getMeta());
        self::assertSame(3600, $e->readMeta('wait'));
    }

    public function testItThrowsExceptionOnInvalidStatusCode(): void
    {
        $uriMock = $this->createMock(UriInterface::class);
        $requestMock = $this->createMock(ServerRequestInterface::class);

        $requestMock->expects(self::atLeastOnce())
            ->method('getUri')
            ->willReturn($uriMock);
        $requestMock->expects(self::atLeastOnce())
            ->method('getMethod')
            ->willReturn('GET');
        $uriMock->expects(self::atLeastOnce())
            ->method('getPath')
            ->willReturn('/some/path');

        $this->expectException(\InvalidArgumentException::class);
        $e = new NonExistent($requestMock);
    }
}
