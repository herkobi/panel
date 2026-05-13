<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Events\Panel\Settings\Roles\RolePermissionsSyncedEvent;

class LogRolePermissionsSynced
{
    public function handle(RolePermissionsSyncedEvent $event): void
    {
        $causerName = $event->causer->name;
        $roleName = $event->role->name;
        $addedCount = \count($event->added);
        $removedCount = \count($event->removed);

        activity('panel.role')
            ->performedOn($event->role)
            ->causedBy($event->causer)
            ->event('permissions_synced')
            ->withProperties([
                'role_uuid' => $event->role->getKey(),
                'role_name' => $event->role->name,
                'added' => $event->added,
                'removed' => $event->removed,
            ])
            ->log("{$causerName}, {$roleName} rolünün izinlerini güncelledi ({$addedCount} eklendi, {$removedCount} kaldırıldı).");
    }
}
