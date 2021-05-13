<?php

namespace Octopy\Inotify\Event;

use Closure;

/**
 * Class InotifyEvent
 * @package Octopy\Inotify\Event
 */
class InotifyEvent
{
    /**
     * @var int
     */
    public int $mask = IN_ALL_EVENTS;

    /**
     * @var array
     */
    public array $actions = [];

    /**
     * InotifyEvent constructor.
     * @param  Closure|null $callback
     */
    public function __construct(Closure $callback = null)
    {
        if ($callback) {
            $callback($this);
        }
    }

    /**
     * @param  int     $event
     * @param  Closure $action
     */
    public function on(int $event, Closure $action) : void
    {
        $this->actions[$event] = $action;
    }

    /**
     * @param  int $mask
     */
    public function mask(int $mask)
    {
        $this->mask = $mask;
    }

    /**
     * @param  int $event
     * @return callable
     */
    public function get(int $event) : callable
    {
        return $this->actions[$event];
    }

    /**
     * @param  int $event
     * @return bool
     */
    public function exist(int $event) : bool
    {
        return isset($this->actions[$event]);
    }
}
