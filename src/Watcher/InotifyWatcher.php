<?php

namespace Octopy\Inotify\Watcher;

use Closure;
use Exception;
use Illuminate\Support\Collection;
use Octopy\Inotify\Contract\Watcher;
use Octopy\Inotify\Event\InotifyExecutedEvent;

/**
 * Class InotifyWatcher
 * @package Octopy\Inotify\Watcher
 */
class InotifyWatcher extends AbstractWatcher implements Watcher
{
    /**
     * @param  Closure $callback
     */
    public function watch(Closure $callback = null) : void
    {
        if (! $this->inotify && ! $this->watcher) {
            $this->prepare();
        }

        while ($this->status) {
            if ($this->memoryExceeded()) {
                $this->terminate();
            }

            sleep($this->app->delays);

            if ($this->status) {
                $events = inotify_read($this->inotify);

                if (! empty($events)) {
                    $events = $this->eventsMapping($events);

                    $events->each(function ($event) {
                        $this->execute($event);
                    });

                    if ($callback) {
                        $callback(new InotifyExecutedEvent($events), $this);
                    }
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function terminate() : bool
    {
        if (! inotify_rm_watch($this->inotify, $this->watcher)) {
            // TODO
        }

        if (! fclose($this->inotify)) {
            // TODO
        }

        return ! $this->status = false;
    }

    /**
     * @return void
     */
    protected function prepare() : void
    {
        try {
            pcntl_async_signals(true);
            pcntl_signal(SIGINT, [$this, 'terminate']);
            pcntl_signal(SIGHUP, [$this, 'terminate']);
        } catch (Exception $exception) {
            throw $exception;
        }

        $this->inotify = inotify_init();

        // this is needed so inotify_read while operate in non blocking mode
        stream_set_blocking($this->inotify, false);

        $this->watcher = inotify_add_watch(
            $this->inotify, $this->app->source->path, $this->app->event->mask
        );
    }

    /**
     * @param  Collection $event
     */
    protected function execute($event) : void
    {
        $mask = $event->get('mask');

        if ($this->app->event->exist($mask)) {
            call_user_func($this->app->event->get($mask), $this);
        } else if ($mask === IN_DELETE) {
            $this->terminate(); // terminate process if IN_DELETE mask doesn't exists on registered event.
        }
    }

    /**
     * @param  bool|array $events
     * @return Collection
     */
    private function eventsMapping(bool|array $events) : Collection
    {
        return collect($events)->unique('mask')->map(function (array $event) {
            return collect($event);
        });
    }
}
