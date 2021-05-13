<?php

namespace Octopy\Inotify\Tests;

use Illuminate\Foundation\Application;
use Octopy\Inotify\InotifyServiceProvider;

/**
 * Class TestCase
 * @package Octopy\Inotify\Tests
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();
    }

    /**
     * @param  Application $app
     * @return string[]
     */
    protected function getPackageProviders($app) : array
    {
        return [
            InotifyServiceProvider::class,
        ];
    }
}
