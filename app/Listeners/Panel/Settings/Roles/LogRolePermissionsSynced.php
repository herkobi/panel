<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\Roles\RolePermissionsSyncedEvent;

class LogRolePermissionsSynced
{
    use LogsActivity;

    public function handle(RolePermissionsSyncedEvent $event): void
    {
        $causerName = $event->causer->name;
        $roleName = $event->role->name;
        $addedCount = \count($event->added);
        $removedCount = \count($event->removed);

        $this->logActivity(
            logName: 'panel.role',
            subject: $event->role,
            causer: $event->causer,
            event: 'permissions_synced',
            message: "{$causerName}, {$roleName} rolünün izinlerini güncelledi ({$addedCount} eklendi, {$removedCount} kaldırıldı).",
            properties: [
                'role_uuid' => $event->role->getKey(),
                'role_name' => $event->role->name,
                'added' => $event->added,
                'removed' => $event->removed,
            ],
        );
    }
}
