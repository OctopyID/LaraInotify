# Lara Inotify

Lara Inotify is a wrapper for [inotify](https://www.php.net/manual/en/book.inotify.php) for Laravel to make it easier to
watch filesystem and avoid memory leaks.

## Requirement

- [PHP v8.x](https://www.php.net/downloads/)
    - [ext-pcntl](https://www.php.net/manual/en/book.pcntl.php)
    - [ext-inotify](https://www.php.net/manual/en/book.inotify.php)
- [Laravel v8.x](https://laravel.com/)

## Installation

To install the package, simply follow the steps below.

Install the package using Composer:

```
$ composer require octopyid/laravel-inotify

$ artisan vendor:publish --provider="Octopy\Inotify\InotifyServiceProvider"
```

## Usage

See [WIKI](https://github.com/OctopyID/LaraInotify/wiki) for more details.

```php
use Octopy\Inotify\Inotify;
use Octopy\Inotify\Contract\Event;
use Octopy\Inotify\Contract\Watcher;

$inotify = new Inotify('foo.txt');

$inotify->event(function (Event $event) {

    $event->on(IN_MODIFY, function (Watcher $watcher) {
        // do something
    });
    
    $event->on(IN_DELETE, function (Watcher $watcher) {
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
