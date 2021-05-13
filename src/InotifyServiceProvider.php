<?php

namespace Octopy\Inotify;

use Illuminate\Support\ServiceProvider;

/**
 * Class InotifyServiceProvider
 * @package Octopy\Inotify
 */
class InotifyServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/inotify.php', 'inotify'
        );
    }

    /**
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/inotify.php' => config_path('inotify.php'),
            ], 'inotify');
        }
    }
}
