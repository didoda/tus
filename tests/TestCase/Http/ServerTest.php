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
        $server->getRequest()->getRequest()->server->set('REQUEST_URI', '/testuploads');
        $server->updateCache();
        $key = $server->getRequest()->key();
        $cache = $server->getCache();
        $this->assertNull($cache->get($key));

        // cached data exists, but no object id in headers
        // TODO: make it work
        // $cache->set($key, 'foo');
        // $server->setCache($cache);
        // $server->updateCache();
        // $this->assertSame('foo', $cache->get($key));

        // cached data exists, object id and object type in headers
        // TODO: make it work
        // $response = $server->getResponse();
        // $headers = $response->getHeaders();
        // $headers[] = Server::BEDITA_OBJECT_ID_HEADER . ': 42';
        // $headers[] = Server::BEDITA_OBJECT_TYPE_HEADER . ': "documents"';
        // $response->setHeaders($headers);
        // $server->setResponse($response);
        // $server->updateCache();
        // $expected = ['foo' => 'bar', ['bedita' => ['object_id' => 42, 'object_type' => 'documents']]];
        // $this->assertSame($expected, $server->getCache()->get($key));
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
