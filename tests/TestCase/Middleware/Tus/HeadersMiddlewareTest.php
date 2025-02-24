<?php
declare(strict_types=1);

/**
 * BEdita, API-first content management framework
 * Copyright 2025 Atlas Srl, Chialab Srl
 *
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See LICENSE.LGPL or <http://gnu.org/licenses/lgpl-3.0.html> for more details.
 */

namespace BEdita\Tus\Test\TestCase\Middleware;

use BEdita\Tus\Http\Server;
use BEdita\Tus\Middleware\Tus\HeadersMiddleware;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use TusPhp\Request;
use TusPhp\Response;

#[CoversClass(HeadersMiddleware::class)]
class HeadersMiddlewareTest extends TestCase
{
    /**
     * Test `__contruct` method
     */
    public function testContructor(): void
    {
        $middleware = new HeadersMiddleware(['exclude' => 'header1,header2']);
        $this->assertSame(['exclude' => ['header1', 'header2']], $middleware->getConfig());
    }

    /**
     * Test `handle`, `unsetHeader`, `extendsCors` methods
     */
    public function testHeaders(): void
    {
        $middleware = new HeadersMiddleware(['exclude' => 'Custom']);
        $request = new Request();
        $response = new Response();
        $response->setHeaders([
            'Access-Control-Allow-Headers' => 'test',
            'Access-Control-Expose-Headers' => 'test',
            'Custom' => 'header1,header2,header3',
        ]);
        $middleware->handle($request, $response);
        $headers = $response->getHeaders();
        $this->assertFalse(in_array('Custom', array_keys($headers)));
        $expected = 'test, ' . Server::BEDITA_OBJECT_ID_HEADER . ', ' . Server::BEDITA_OBJECT_TYPE_HEADER;
        $this->assertSame($expected, $headers['Access-Control-Expose-Headers']);
    }
}
