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

use BEdita\Tus\Middleware\TusMiddleware;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

#[CoversClass(TusMiddleware::class)]
class TusMiddlewareTest extends TestCase
{
    /**
     * Test `__contruct` method
     */
    public function testContructor(): void
    {
        $middleware = new TusMiddleware(['endpoint' => 'my/files']);
        $this->assertSame(['endpoint' => '/my/files'], $middleware->getConfig());
    }

    /**
     * Test `process` method
     */
    public function testProcess(): void
    {
        // method is not OPTIONS and no endpoint in config
        $middleware = new TusMiddleware([]);
        $request = new ServerRequest();
        $response = $this->createMock(ResponseInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);
        $this->assertSame($response, $middleware->process($request, $handler));

        // method is OPTIONS and endpoint in config
        $request = new ServerRequest(
            [
                'environment' => ['REQUEST_METHOD' => 'OPTIONS'],
            ]
        );
        $middleware = new TusMiddleware([]);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $tusConf = Configure::read('Tus');
        $tusConf['headers'] = ['exclude' => ['Access-Control-Allow-Origin']];
        $tusConf['endpoint'] = '/';
        $middleware->setConfig($tusConf);
        $actual = $middleware->process($request, $handler);
        $this->assertInstanceOf(Response::class, $actual);
    }
}
