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

use BEdita\Core\Model\Table\MediaTable;
use BEdita\Core\Model\Table\StreamsTable;
use BEdita\Tus\Event\UploadListener;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UploadListener::class)]
class UploadListenerTest extends TestCase
{
    use LocatorAwareTrait;

    /**
     * Test `__contruct` method on exception
     */
    public function testContructorException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing "objectType" entity or not valid');
        new UploadListener();
    }

    /**
     * Test `__contruct` and `setTable` methods
     */
    public function testBase(): void
    {
        $listener = new class () extends UploadListener {
            public function __construct(array $config = [])
            {
                /** @var \BEdita\Core\Model\Table\ObjectTypesTable $objectTypesTable */
                $objectTypesTable = $this->fetchTable('ObjectTypes');
                $objectType = $objectTypesTable->newEntity([
                    'name' => 'media',
                    'singular' => 'media',
                    'plural' => 'media',
                    'description' => 'Media object type',
                    'plugin' => 'BEdita/Core',
                    'model' => 'Objects',
                    'associations' => [],
                    'hidden' => [],
                    'metadata' => [],
                ]);
                $config['objectType'] = $objectType;
                parent::__construct($config);
            }

            public function getStreams(): StreamsTable
            {
                return $this->Streams;
            }

            public function getTable(): Table
            {
                return $this->Table;
            }
        };
        $this->assertInstanceOf(MediaTable::class, $listener->getTable());
        $this->assertInstanceOf(StreamsTable::class, $listener->getStreams());
    }

    /**
     * Test `setTable` method on exception
     */
    public function testSetTableException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('table objects must represent a media');
        $listener = new class () extends UploadListener {
            public function __construct(array $config = [])
            {
                /** @var \BEdita\Core\Model\Table\ObjectTypesTable $objectTypesTable */
                $objectTypesTable = $this->fetchTable('ObjectTypes');
                $objectType = $objectTypesTable->newEntity([
                    'name' => 'media',
                    'singular' => 'media',
                    'plural' => 'media',
                    'description' => 'Media object type',
                    'plugin' => 'BEdita/Core',
                    'model' => 'Objects',
                    'associations' => [],
                    'hidden' => [],
                    'metadata' => [],
                ]);
                $config['objectType'] = $objectType;
                parent::__construct($config);
            }

            public function setTable(string $table): void
            {
                parent::setTable($table);
            }
        };
        $listener->setTable('objects');
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
