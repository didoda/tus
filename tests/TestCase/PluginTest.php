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
namespace BEdita\Tus\Test\TestCase;

use BEdita\API\Middleware\CorsMiddleware;
use BEdita\Tus\Middleware\TusMiddleware;
use BEdita\Tus\Plugin;
use Cake\Core\Configure;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Plugin::class)]
class PluginTest extends TestCase
{
    /**
     * Test subject.
     *
     * @var \BEdita\Tus\Plugin
     */
    protected Plugin $plugin;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->plugin = new Plugin();
    }

    /**
     * Test {@see Plugin::bootstrap()} method.
     *
     * @return void
     */
    public function testBootstrap(): void
    {
        $app = new class (CONFIG) extends BaseApplication {
            public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
            {
                return $middlewareQueue;
            }
        };
        $this->plugin->bootstrap($app);
        $actual = Configure::read('Tus');
        static::assertNotEmpty($actual);
    }

    /**
     * Test {@see Plugin::middleware()} method.
     *
     * @return void
     */
    public function testMiddleware(): void
    {
        $app = new class (CONFIG) extends BaseApplication {
            public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
            {
                return $middlewareQueue;
            }
        };
        $this->plugin->bootstrap($app);
        $middleware = new MiddlewareQueue();
        $middleware->add(new CorsMiddleware());
        $middleware = $this->plugin->middleware($middleware);
        $middleware->rewind();
        $expected = [
            TusMiddleware::class,
            CorsMiddleware::class,
        ];
        $i = 0;
        while ($i < 2) {
            $current = $middleware->current();
            static::assertInstanceOf($expected[$i++], $current);
            $middleware->next();
        }
    }
}
