<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Events\Panel\Settings\Roles\RoleUpdatedEvent;

class LogRoleUpdated
{
    public function handle(RoleUpdatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $roleName = $event->role->name;

        activity('panel.role')
            ->performedOn($event->role)
            ->causedBy($event->causer)
            ->event('updated')
            ->withProperties([
                'role_uuid' => $event->role->getKey(),
                'role_name' => $event->role->name,
                'changes' => $event->changes,
            ])
            ->log("{$causerName}, {$roleName} rolünü güncelledi.");
    }
}
