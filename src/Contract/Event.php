<?php

namespace Octopy\Inotify\Contract;

use Closure;

/**
 * Interface Event
 * @package Octopy\Inotify\Contract
 */
interface Event
{
    /**
     * @param  int     $event
     * @param  Closure $action
     */
    public function on(int $event, Closure $action) : void;

    /**
     * @param  int $mask
     */
    public function mask(int $mask) : void;

    /**
     * @param  int $event
     * @return callable
     */
    public function get(int $event) : callable;

    /**
     * @param  int $event
     * @return bool
     */
    public function exist(int $event) : bool;
}
