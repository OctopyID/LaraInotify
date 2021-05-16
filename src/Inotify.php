<?php

namespace Octopy\Inotify;

use Closure;
use Illuminate\Support\Facades\App;
use Octopy\Inotify\Event\InotifyEvent;
use Octopy\Inotify\Exceptions\MissingSourceException;
use Octopy\Inotify\FileSystem\InotifySource;
use Octopy\Inotify\Watcher\InotifyWatcher;

/**
 * Class Inotify
 * @package Octopy\Inotify
 *
 * @property InotifyEvent  $event
 * @property InotifySource $source
 * @property int           $delays
 * @property int           $memory
 */
class Inotify
{
    /**
     * @var InotifyEvent
     */
    protected $event;

    /**
     * @var InotifySource
     */
    protected $source;

    /**
     * @var int
     */
    protected int $delays;

    /**
     * @var int
     */
    protected int $memory;

    /**
     * Inotify constructor.
     * @param  InotifySource|null $source
     * @param  InotifyEvent|null  $event
     */
    public function __construct(string|null $source = null, Closure|null $event = null)
    {
        if (! is_null($this->source)) {
            $this->source(new InotifySource($source));
        }

        if (is_null($event) || $event instanceof Closure) {
            $this->event = new InotifyEvent($event);
        }

        $this->event->mask(
            config('inotify.events', IN_ALL_EVENTS)
        );

        $this->delays = config('inotify.delays', 3);
        $this->memory = config('inotify.memory', 1024);
    }

    /**
     * @param  string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->$property;
    }

    /**
     * @param  int $mask
     * @return Inotify
     */
    public function mask(int $mask) : Inotify
    {
        $this->event->mask($mask);

        return $this;
    }

    /**
     * @param  Closure $event
     * @return Inotify
     */
    public function event(Closure $event) : Inotify
    {
        $event($this->event);

        return $this;
    }

    /**
     * @param  int $delays
     * @return Inotify
     */
    public function delays(int $delays) : Inotify
    {
        $this->delays = $delays;

        return $this;
    }

    /**
     * @param  int $memory
     * @return Inotify
     */
    public function memory(int $memory) : Inotify
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * @param  InotifySource|string $source
     * @return Inotify
     * @throws Exceptions\PathNotFoundException
     */
    public function source(InotifySource|string $source) : Inotify
    {
        if (! $source instanceof InotifySource) {
            $source = new InotifySource($source);
        }

        $this->source = $source;

        return $this;
    }

    /**
     * @param  Closure|null $callback
     */
    public function watch(Closure $callback = null)
    {
        if (! $this->source) {
            throw new MissingSourceException('No file or directory to watch.');
        }

        return App::make(InotifyWatcher::class, [
            'app' => $this,
        ])
            ->watch($callback);
    }
}
