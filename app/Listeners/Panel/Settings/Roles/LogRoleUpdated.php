<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\Roles\RoleUpdatedEvent;

class LogRoleUpdated
{
    use LogsActivity;

    public function handle(RoleUpdatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $roleName = $event->role->name;

        $this->logActivity(
            logName: 'panel.role',
            subject: $event->role,
            causer: $event->causer,
            event: 'updated',
            message: "{$causerName}, {$roleName} rolünü güncelledi.",
            properties: [
                'role_uuid' => $event->role->getKey(),
                'role_name' => $event->role->name,
                'changes' => $event->changes,
            ],
        );
    }
}
