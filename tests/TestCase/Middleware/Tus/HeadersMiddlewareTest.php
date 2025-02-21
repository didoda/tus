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

use BEdita\Tus\Middleware\Tus\HeadersMiddleware;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HeadersMiddleware::class)]
class HeadersMiddlewareTest extends TestCase
{
    /**
     * Test `__contruct` method
     */
    public function testContructor(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `handle` method
     */
    public function testHandle(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `unsetHeader` method
     */
    public function testUnsetHeader(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `extendsCors` method
     */
    public function testExtendsCors(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
