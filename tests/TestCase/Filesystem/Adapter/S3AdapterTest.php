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

namespace BEdita\Tus\Test\TestCase\Filesystem\Adapter;

use Aws\S3\S3Client;
use BEdita\Tus\Filesystem\Adapter\S3Adapter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(S3Adapter::class)]
class S3AdapterTest extends TestCase
{
    /**
     * Test `getClient` method
     */
    public function testGetClient(): void
    {
        $adapter = new class () extends S3Adapter {
            public function setMock(): void
            {
                $this->client = new S3Client([
                    'region' => 'us-east-1',
                ]);
            }
        };
        $adapter->setMock();
        $this->assertInstanceOf(S3Client::class, $adapter->getClient());
    }
}
