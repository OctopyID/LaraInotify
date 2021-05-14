<?php

namespace Octopy\Inotify\Contract;

use Illuminate\Support\Collection;

/**
 * Interface ExecutedEvent
 * @package Octopy\Inotify\Contract
 */
interface ExecutedEvent
{
    /**
     * @param  int $mask
     * @return bool
     */
    public function is(int $mask) : bool;

    /**
     * @return Collection
     */
    public function events() : Collection;
}
