<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Permissions;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\Permissions\PermissionCreatedEvent;

class LogPermissionCreated
{
    use LogsActivity;

    public function handle(PermissionCreatedEvent $event): void
    {
        $causerName = $event->causer->name;

        $this->logActivity(
            logName: 'panel.permission',
            subject: $event->permission,
            causer: $event->causer,
            event: 'created',
            message: "{$causerName}, '{$event->permission->name}' iznini ekledi.",
            properties: [
                'group' => $event->permission->group,
                'label' => $event->permission->label,
            ],
        );
    }
}
