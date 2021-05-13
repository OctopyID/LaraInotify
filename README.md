<p align="center">
    <img src="https://img.shields.io/packagist/v/octopyid/laravel-inotify.svg?style=for-the-badge" alt="Version">
    <img src="https://img.shields.io/packagist/dt/octopyid/laravel-inotify.svg?style=for-the-badge&color=F28D1A" alt="Downloads">
    <img src="https://img.shields.io/packagist/l/octopyid/laravel-inotify.svg?style=for-the-badge" alt="License">
</p>

# Lara Inotify

Lara Inotify is a wrapper for [inotify](https://www.php.net/manual/en/book.inotify.php) for Laravel with added some
functions to make it easier to watch filesystem and avoid memory leaks.

## Requirement

- [PHP v8.x](https://www.php.net/downloads/)
- [Laravel v8.x](https://laravel.com/)


- [ext-pcntl](https://www.php.net/manual/en/book.pcntl.php)
- [ext-inotify](https://www.php.net/manual/en/book.inotify.php)

## Installation

To install the package, simply follow the steps below.

Install the package using Composer:

```
$ composer require octopyid/laravel-watcher

$ artisan vendor:publish --provider="Octopy\Inotify\InotifyServiceProvider"
```

## Basic Usage

```php
use Octopy\Inotify\Inotify;
use Octopy\Inotify\Event\InotifyEvent;
use Octopy\Inotify\Watcher\InotifyWatcher;

$inotify = new Inotify('foo.txt');

$inotify->event(function (InotifyEvent $event) {

    $event->on(IN_MODIFY, function (InotifyWatcher $watcher) {
        // do something
    });
    
    $event->on(IN_DELETE, function (InotifyWatcher $watcher) {
        // do something
    });

    // see : https://www.php.net/manual/en/inotify.constants.php for more events.
});


$inotify->watch();
```

## Security

If you discover any security related issues, please email [supianidz@gmail.com](mailto:supianidz@gmail.com) instead of
using the issue tracker.

## Credits

- [Supian M](https://github.com/SupianIDz)
- [Octopy ID](https://github.com/OctopyID)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
