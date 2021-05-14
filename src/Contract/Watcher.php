<?php

namespace Octopy\Inotify\Contract;

/**
 * Interface Watcher
 * @package Octopy\Inotify\Contract
 */
interface Watcher
{
    /**
     * @return bool
     */
    public function terminate() : bool;
}
