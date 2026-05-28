<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Permissions;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\Permissions\PermissionsBulkAddedEvent;

class LogPermissionsBulkAdded
{
    use LogsActivity;

    public function handle(PermissionsBulkAddedEvent $event): void
    {
        if ($event->names === []) {
            return;
        }

        $causerName = $event->causer->name;
        $count = count($event->names);

        $this->logActivity(
            logName: 'panel.permission',
            causer: $event->causer,
            event: 'bulk_added',
            message: "{$causerName}, rotalardan {$count} izin keşfedip ekledi.",
            properties: ['names' => $event->names],
        );
    }
}
