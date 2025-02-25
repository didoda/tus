<?php

declare(strict_types=1);

/**
 * BEdita, API-first content management framework
 * Copyright 2021 ChannelWeb Srl, Chialab Srl
 *
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See LICENSE.LGPL or <http://gnu.org/licenses/lgpl-3.0.html> for more details.
 */

namespace BEdita\Tus\Filesystem\Adapter;

use Aws\S3\S3Client;
use BEdita\AWS\Filesystem\Adapter\S3Adapter as BEditaS3Adapter;

class S3Adapter extends BEditaS3Adapter
{
    /**
     * Get the S3 client.
     *
     * @return \Aws\S3\S3Client
     */
    public function getClient(): S3Client
    {
        return parent::getClient();
    }
}
