<?php

namespace Octopy\Inotify\Event;

use Illuminate\Support\Collection;

/**
 * Class InotifyCalledEvent
 * @package Octopy\Inotify\Event
 */
class InotifyCalledEvent
{
    /**
     * InotifyCalledEvent constructor.
     * @param  array $event
     */
    public function __construct(protected Collection $events)
    {
        //
    }

    /**
     * @param  int $mask
     * @return bool
     */
    public function is(int $mask) : bool
    {
        foreach ($this->events as $event) {
            if ($event->get('mask') === $mask) {
                return true;
            }
        }

        return false;
    }
}
