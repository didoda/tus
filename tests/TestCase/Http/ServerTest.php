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
use BEdita\Tus\Http\ServerFactory;
use Cake\Core\Configure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(Server::class)]
class ServerTest extends TestCase
{
    /**
     * Test `updateCache` method
     */
    public function testUpdateCache(): void
    {
        // no cached data
        $tusConf = Configure::read('Tus');
        $tusConf['endpoint'] .= '/files';
        $server = ServerFactory::create($tusConf);
        $server->getRequest()->getRequest()->server->set('REQUEST_URI', '/mytestuploads' . rand(1, 1000));
        $server->updateCache();
        $key = $server->getRequest()->key();
        $cache = $server->getCache();
        $this->assertNull($cache->get($key));

        // cached data exists, but no object id in headers
        $val = ['expires_at' => 'Wed, 24 Feb 2026 12:34:56 GMT', 'data' => ['foo' => 'bar']];
        $cache->set($key, $val);
        $server->setCache($cache);
        $server->updateCache();
        $this->assertSame($val, $cache->get($key));

        // cached data exists, object id and object type in headers
        $response = $server->getResponse();
        $headers = $response->getHeaders();
        $headers[Server::BEDITA_OBJECT_ID_HEADER] = 42;
        $headers[Server::BEDITA_OBJECT_TYPE_HEADER] = 'documents';
        $response->setHeaders($headers);
        $server->setResponse($response);
        $server->updateCache();
        $expected = $val + ['bedita' => ['object_id' => 42, 'object_type' => 'documents']];
        $this->assertSame($expected, $server->getCache()->get($key));
    }

    /**
     * Test `serve` method
     */
    public function testServe(): void
    {
        $tusConf = Configure::read('Tus');
        $tusConf['endpoint'] .= '/files';
        $server = ServerFactory::create($tusConf);
        $server->getRequest()->getRequest()->server->set('REQUEST_URI', '/mytestuploads' . rand(1, 1000));
        $cache = $server->getCache();
        $key = $server->getRequest()->key();
        $val = ['expires_at' => 'Wed, 24 Feb 2026 12:34:56 GMT', 'data' => ['foo' => 'bar']];
        $cache->set($key, $val);
        $server->setCache($cache);
        $response = $server->getResponse();
        $headers = $response->getHeaders();
        $headers[Server::BEDITA_OBJECT_ID_HEADER] = 42;
        $headers[Server::BEDITA_OBJECT_TYPE_HEADER] = 'documents';
        $response->setHeaders($headers);
        $server->setResponse($response);
        $actual = $server->serve();
        $this->assertInstanceOf(Response::class, $actual);
        $expected = $val + ['bedita' => ['object_id' => 42, 'object_type' => 'documents']];
        $this->assertSame($expected, $server->getCache()->get($key));
    }

    /**
     * Test `handleHead` method
     */
    public function testHandleHead(): void
    {
        $tusConf = Configure::read('Tus');
        $tusConf['endpoint'] .= '/files';
        $server = ServerFactory::create($tusConf);
        $server->getRequest()->getRequest()->server->set('REQUEST_URI', '/mytestuploads' . rand(1, 1000));
        // handle head is protected... make it public through reflection
        $method = new ReflectionMethod(Server::class, 'handleHead');
        $method->setAccessible(true);
        $actual = $method->invoke($server);
        $this->assertInstanceOf(Response::class, $actual);
        $cache = $server->getCache();
        $key = $server->getRequest()->key();
        $this->assertNull($cache->get($key));

        // set cache data
        $expected = [
            'expires_at' => 'Wed, 24 Feb 2026 12:34:56 GMT',
            'data' => ['foo' => 'bar'],
            'bedita' => [
                'object_id' => 42,
                'object_type' => 'documents',
            ],
        ];
        $cache->set($key, $expected);
        $server->setCache($cache);
        $actual = $method->invoke($server);
        $this->assertInstanceOf(Response::class, $actual);
        $headers = $actual->headers->allPreserveCase();
        $this->assertSame('42', $headers[Server::BEDITA_OBJECT_ID_HEADER][0]);
        $this->assertSame('documents', $headers[Server::BEDITA_OBJECT_TYPE_HEADER][0]);
    }

    /**
     * Test `handlePatch` method
     */
    public function testHandlePatch(): void
    {
        $tusConf = Configure::read('Tus');
        $tusConf['endpoint'] .= '/files';
        $server = ServerFactory::create($tusConf);
        $server->getRequest()->getRequest()->server->set('REQUEST_URI', '/mytestuploads' . rand(1, 1000));
        $expected = [
            'expires_at' => 'Wed, 24 Feb 2026 12:34:56 GMT',
            'data' => ['foo' => 'bar'],
            'bedita' => [
                'object_id' => 42,
                'object_type' => 'documents',
            ],
        ];
        $cache = $server->getCache();
        $key = $server->getRequest()->key();
        $cache->set($key, $expected);
        $server->setCache($cache);
        // handle patch is protected... make it public through reflection
        $method = new ReflectionMethod(Server::class, 'handlePatch');
        $method->setAccessible(true);
        $actual = $method->invoke($server);
        $this->assertInstanceOf(Response::class, $actual);
    }
}
