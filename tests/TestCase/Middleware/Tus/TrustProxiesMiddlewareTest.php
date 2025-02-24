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

use BEdita\Tus\Middleware\Tus\TrustProxiesMiddleware;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use TusPhp\Request;
use TusPhp\Response;

#[CoversClass(TrustProxiesMiddleware::class)]
class TrustProxiesMiddlewareTest extends TestCase
{
    /**
     * Test `__contruct` method
     */
    public function testContructor(): void
    {
        // headers null
        $middleware = new TrustProxiesMiddleware([
            'headers' => null,
        ]);
        $actual = $middleware->getConfig('headers');
        $this->assertCount(5, $actual);

        // headers string
        $middleware = new TrustProxiesMiddleware([
            'headers' => 'X-Forwarded-Proto',
        ]);
        $actual = $middleware->getConfig('headers');
        $this->assertCount(6, $actual);

        // proxies
        $middleware = new TrustProxiesMiddleware([
            'proxies' => 'test',
        ]);
        $actual = $middleware->getConfig('proxies');
        $expected = ['test'];
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test `handle`, `getProxies` and `getTrustedHeaders` methods
     */
    public function testHeadersAndProxies(): void
    {
        $middleware = new TrustProxiesMiddleware([
            'proxies' => 'test',
        ]);
        $request = new Request();
        $response = new Response();
        $middleware->handle($request, $response);
        $actual = $request->getRequest()->getTrustedProxies();
        $this->assertSame(['test'], $actual);

        // proxies *
        $middleware = new TrustProxiesMiddleware([
            'proxies' => '*',
        ]);
        $request = new Request();
        $response = new Response();
        $middleware->handle($request, $response);
        $actual = $request->getRequest()->getTrustedProxies();
        $actual = array_filter($actual);
        $this->assertEmpty($actual);
    }
}
