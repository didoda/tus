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

namespace BEdita\Tus\Test\TestCase\Command;

use BEdita\Tus\Command\CleanExpiredCommand;
use Cake\Console\TestSuite\ConsoleIntegrationTestTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CleanExpiredCommand::class)]
class CleanExpiredCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->useCommandRunner();
    }

    /**
     * Test `execute` and `tusServer` methods
     */
    public function testExecute(): void
    {
        $this->exec('clean_expired');
        $this->assertOutputContains('Cleaning server resources');
        $this->assertOutputContains('Nothing to delete.');
        $this->assertOutputContains('Done');
    }
}
