<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Event Mask
    |--------------------------------------------------------------------------
    |
    | The following constant is to determine the inotify mask by default.
    |
    | See https://www.php.net/manual/en/inotify.constants.php for a list of available constants.
    |
    */
    'events' => IN_ALL_EVENTS,

    /*
    |--------------------------------------------------------------------------
    | Delay
    |--------------------------------------------------------------------------
    |
    | Delays the event execution for the given number of seconds.
    |
    */
    'delays' => env('INOTIFY_DELAYS', 3),

    /*
    |--------------------------------------------------------------------------
    | Memory Allocation
    |--------------------------------------------------------------------------
    |
    | Maximum memory allocation to avoid crashes on the machine in mega bytes.
    |
    | Default : 128 MB
    */
    'memory' => env('INOTIFY_MAX_MEMORY', 128),
];
