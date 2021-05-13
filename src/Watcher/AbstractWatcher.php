<?php

namespace Octopy\Inotify\Watcher;

use Closure;
use Illuminate\Support\Collection;
use Octopy\Inotify\Inotify;

/**
 * Class AbstractWatcher
 * @package Octopy\Inotify\Watcher
 */
abstract class AbstractWatcher
{
    protected array $config = [];

    /**
     * @var bool
     */
    protected bool $status = true;

    /**
     * @var false|resource
     */
    protected mixed $inotify;

    /**
     * @var
     */
    protected mixed $watcher;

    /**
     * AbstractWatcher constructor.
     * @param  Inotify $app
     */
    public function __construct(protected Inotify $app)
    {
        $this->prepare();
    }

    /**
     * @return bool
     */
    public function memoryExceeded() : bool
    {
        return (memory_get_usage(true) / 1024 / 1024) >= $this->app->memory;
    }

    /**
     * @param  Closure|null $callback
     */
    public abstract function watch(Closure $callback = null) : void;

    /**
     * @return void
     */
    protected abstract function prepare() : void;

    /**
     * @param  Collection $event
     * @return void
     */
    protected abstract function execute($event) : void;

    /**
     * @return bool
     */
    protected abstract function terminate() : bool;
}
