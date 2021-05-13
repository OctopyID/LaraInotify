<?php

namespace Octopy\Inotify\FileSystem;

use Octopy\Inotify\Exceptions\PathNotFoundException;

/**
 * Class FileSystem
 * @package Octopy\Inotify\FileSystem
 * @property string $path
 * @property string $name
 * @property int    $mask
 */
class InotifySource
{
    /**
     * InotifyFileSystem constructor.
     * @param  string $path
     */
    public function __construct(public string $path)
    {
        if (! file_exists($this->path) && ! is_dir($this->path)) {
            throw new PathNotFoundException(
                sprintf('The file or directory "%s" does not exist', $this->path)
            );
        }
    }
}
