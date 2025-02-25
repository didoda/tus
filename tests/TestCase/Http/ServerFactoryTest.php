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

use BEdita\Core\Filesystem\Adapter\LocalAdapter;
use BEdita\Core\Filesystem\FilesystemRegistry;
use BEdita\Tus\Http\Server;
use BEdita\Tus\Http\ServerFactory;
use BEdita\Tus\Test\TestApp\Filesystem\MyAdapter;
use Cake\Core\Configure;
use Cake\Http\Exception\InternalErrorException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServerFactory::class)]
class ServerFactoryTest extends TestCase
{
    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        parent::tearDown();
        FilesystemRegistry::dropAll();
        Configure::write('Filesystem', [
            'tus' => [
                'className' => LocalAdapter::class,
                'path' => 'tests',
                'uploadDir' => 'uploads',
            ],
        ]);
        FilesystemRegistry::getInstance()->setConfig(Configure::read('Filesystem'));
        Configure::write([
            'Tus' => [
                'endpoint' => env('TUS_ENDPOINT', 'tus'),
                'filesystem' => env('TUS_FILESYSTEM', 'tus'),
                'uploadDir' => env('TUS_UPLOAD_DIR', 'uploads'),
                'cache' => env('TUS_CACHE_ENGINE', 'file'),
                'server' => [
                    'redis' => [
                        'host' => env('TUS_REDIS_HOST', '127.0.0.1'),
                        'port' => env('TUS_REDIS_PORT', '6379'),
                        'database' => env('TUS_REDIS_DB', 0),
                    ],
                    'file' => [
                        'dir' => env('TUS_CACHE_DIR', TMP),
                        'name' => env('TUS_CACHE_FILE', 'tus_php.server.cache'),
                    ],
                ],
                'trustedProxies' => [
                    'proxies' => env('TUS_TRUSTED_PROXIES', '*'),
                    'headers' => env('TUS_TRUSTED_HEADERS'),
                ],
                'headers' => [
                    'exclude' => env('TUS_HEADERS_EXCLUDE'),
                ],
            ],
        ]);
    }

    /**
     * Test `__contruct` method
     */
    public function testContructor(): void
    {
        $factory = new ServerFactory(['endpoint' => 'my/files']);
        $this->assertSame('/my/files', $factory->getConfig()['endpoint']);
    }

    /**
     * Test `create`, `getServer`, `setupFilesystem`, `ensureUploadDir` methods
     */
    public function testCreate(): void
    {
        $tusConf = Configure::read('Tus');
        $tusConf['endpoint'] .= '/files';
        $actual = ServerFactory::create($tusConf);
        $this->assertInstanceOf(Server::class, $actual);
    }

    /**
     * Test `setupFilesystem` method with not supported adapter
     */
    public function testSetupFilesystemException(): void
    {
        $this->expectException(InternalErrorException::class);
        $this->expectExceptionMessage('Filesystem not supported');
        FilesystemRegistry::dropAll();
        Configure::write('Filesystem', [
            'tustest' => [
                'className' => MyAdapter::class,
                'path' => 'tests',
                'uploadDir' => 'uploads',
            ],
        ]);
        Configure::write([
            'Tus' => [
                'endpoint' => env('TUS_ENDPOINT', 'tus'),
                'filesystem' => env('TUS_FILESYSTEM', 'tustest'),
                'uploadDir' => env('TUS_UPLOAD_DIR', 'uploads'),
                'cache' => env('TUS_CACHE_ENGINE', 'file'),
                'server' => [
                    'redis' => [
                        'host' => env('TUS_REDIS_HOST', '127.0.0.1'),
                        'port' => env('TUS_REDIS_PORT', '6379'),
                        'database' => env('TUS_REDIS_DB', 0),
                    ],
                    'file' => [
                        'dir' => env('TUS_CACHE_DIR', TMP),
                        'name' => env('TUS_CACHE_FILE', 'tus_php.server.cache'),
                    ],
                ],
                'trustedProxies' => [
                    'proxies' => env('TUS_TRUSTED_PROXIES', '*'),
                    'headers' => env('TUS_TRUSTED_HEADERS'),
                ],
                'headers' => [
                    'exclude' => env('TUS_HEADERS_EXCLUDE'),
                ],
            ],
        ]);
        FilesystemRegistry::getInstance()->setConfig(Configure::read('Filesystem'));
        $tusConf = Configure::read('Tus');
        $tusConf['endpoint'] .= '/files';
        ServerFactory::create($tusConf);
    }
}
