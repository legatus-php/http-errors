<?php

namespace Legatus\Http\Errors;

use Legatus\Http\Errors\Builder\Builder;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @param Request $request
 * @return Builder
 */
function make_for(Request $request): Builder
{
    return new Builder($request);
}
