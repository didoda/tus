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

namespace BEdita\Tus\Test\TestCase\Event;

use BEdita\Tus\Event\UploadListener;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UploadListener::class)]
class UploadListenerTest extends TestCase
{
    /**
     * Test `__contruct` method
     */
    public function testContructor(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `setTable` method
     */
    public function testSetTable(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `onUploadComplete` method
     */
    public function testOnUploadComplete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test `finalize` method
     */
    public function testFinalize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
