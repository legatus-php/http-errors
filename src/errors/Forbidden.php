<?php

declare(strict_types=1);

/*
 * This file is part of the Legatus project organization.
 * (c) Matías Navarro-Carter <contact@mnavarro.dev>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Legatus\Http;

/**
 * Class Forbidden.
 */
class Forbidden extends HttpError
{
    private const CODE = 403;

    /**
     * @return int
     */
    public static function statusCode(): int
    {
        return self::CODE;
    }
}
