<?php
declare(strict_types=1);

namespace BEdita\Tus\Test\TestApp\Filesystem;

use BEdita\Core\Filesystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;

/**
 * Test adapter
 */
class MyAdapter extends FilesystemAdapter
{
    /**
     * @inheritDoc
     */
    protected function buildAdapter(array $config)
    {
        return new LocalFilesystemAdapter('');
    }
}
