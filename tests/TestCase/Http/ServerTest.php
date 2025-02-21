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

namespace BEdita\Tus\Test\TestCase\Http;

use BEdita\Tus\Http\Server;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Server::class)]
class ServerTest extends TestCase
{
    /**
     * Test `updateCache` method
     */
    public function testUpdateCache(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `serve` method
     */
    public function testServe(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `handleHead` method
     */
    public function testHandleHead(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `handlePatch` method
     */
    public function testHandlePatch(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
