<?php

namespace Octopy\Inotify\Event;

use Illuminate\Support\Collection;
use Octopy\Inotify\Contract\ExecutedEvent;

/**
 * Class InotifyEventExecuted
 * @package Octopy\Inotify\Event
 */
class InotifyExecutedEvent implements ExecutedEvent
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

    /**
     * @return Collection
     */
    public function events() : Collection
    {
        return $this->events->map(function ($row) : array {
            return $this->getEventsDetail($row->get('mask'));
        })->values();
    }

    /**
     * @param  int $mask
     * @return array
     */
    protected function getEventsDetail(int $mask) : array
    {
        $events = [
            1          => ['IN_ACCESS', 'File was accessed (read)'],
            2          => ['IN_MODIFY', 'File was modified'],
            4          => ['IN_ATTRIB', 'Metadata changed (e.g. permissions, mtime, etc.)'],
            8          => ['IN_CLOSE_WRITE', 'File opened for writing was closed'],
            16         => ['IN_CLOSE_NOWRITE', 'File not opened for writing was closed'],
            32         => ['IN_OPEN', 'File was opened'],
            128        => ['IN_MOVED_TO', 'File moved into watched directory'],
            64         => ['IN_MOVED_FROM', 'File moved out of watched directory'],
            256        => ['IN_CREATE', 'File or directory created in watched directory'],
            512        => ['IN_DELETE', 'File or directory deleted in watched directory'],
            1024       => ['IN_DELETE_SELF', 'Watched file or directory was deleted'],
            2048       => ['IN_MOVE_SELF', 'Watch file or directory was moved'],
            24         => ['IN_CLOSE', 'Equals to IN_CLOSE_WRITE | IN_CLOSE_NOWRITE'],
            192        => ['IN_MOVE', 'Equals to IN_MOVED_FROM | IN_MOVED_TO'],
            4095       => ['IN_ALL_EVENTS', 'Bitmask of all the above constants'],
            8192       => ['IN_UNMOUNT', 'File system containing watched object was unmounted'],
            16384      => ['IN_Q_OVERFLOW', 'Event queue overflowed (wd is -1 for this event)'],
            32768      => ['IN_IGNORED', 'Watch was removed (explicitly by inotify_rm_watch() or because file was removed or filesystem unmounted'],
            1073741824 => ['IN_ISDIR', 'Subject of this event is a directory'],
            1073741840 => ['IN_CLOSE_NOWRITE', 'High-bit: File not opened for writing was closed'],
            1073741856 => ['IN_OPEN', 'High-bit: File was opened'],
            1073742080 => ['IN_CREATE', 'High-bit: File or directory created in watched directory'],
            1073742336 => ['IN_DELETE', 'High-bit: File or directory deleted in watched directory'],
            16777216   => ['IN_ONLYDIR', 'Only watch pathname if it is a directory (Since Linux 2.6.15)'],
            33554432   => ['IN_DONT_FOLLOW', 'Do not dereference pathname if it is a symlink (Since Linux 2.6.15)'],
            536870912  => ['IN_MASK_ADD', 'Add events to watch mask for this pathname if it already exists (instead of replacing mask).'],
            2147483648 => ['IN_ONESHOT', 'Monitor pathname for one event, then remove from watch list.'],
        ];

        if (isset($events[$mask])) {
            return [
                'mask' => $mask,
                'name' => $events[$mask][0],
                'desc' => $events[$mask][1],
            ];
        }

        return [];
    }
}
