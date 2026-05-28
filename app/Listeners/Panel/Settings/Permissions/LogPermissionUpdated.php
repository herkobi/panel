<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Permissions;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\Permissions\PermissionUpdatedEvent;

class LogPermissionUpdated
{
    use LogsActivity;

    public function handle(PermissionUpdatedEvent $event): void
    {
        if ($event->changes === []) {
            return;
        }

        $causerName = $event->causer->name;

        $this->logActivity(
            logName: 'panel.permission',
            subject: $event->permission,
            causer: $event->causer,
            event: 'updated',
            message: "{$causerName}, '{$event->permission->name}' iznini güncelledi.",
            properties: ['changes' => $event->changes],
        );
    }
}
