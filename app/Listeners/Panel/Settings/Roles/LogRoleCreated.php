<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Events\Panel\Settings\Roles\RoleCreatedEvent;

class LogRoleCreated
{
    public function handle(RoleCreatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $roleName = $event->role->name;

        activity('panel.role')
            ->performedOn($event->role)
            ->causedBy($event->causer)
            ->event('created')
            ->withProperties([
                'role_uuid' => $event->role->getKey(),
                'role_name' => $event->role->name,
                'permissions' => $event->permissions,
            ])
            ->log("{$causerName}, {$roleName} rolünü oluşturdu.");
    }
}
