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

use BEdita\Tus\Http\ResponseTrait;
use Cake\Http\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

#[CoversClass(ResponseTrait::class)]
class ResponseTraitTest extends TestCase
{
    use ResponseTrait;

    /**
     * Test `toCakeResponse` method
     */
    public function testToCakeResponse(): void
    {
        $httpResponse = new HttpResponse('{"message": "Hello, World!"}', 200, ['Content-Type' => 'application/json']);
        $response = $this->toCakeResponse($httpResponse);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertSame('{"message": "Hello, World!"}', (string)$response->getBody());
    }
}
