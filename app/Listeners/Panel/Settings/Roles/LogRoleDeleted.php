<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Events\Panel\Settings\Roles\RoleDeletedEvent;

class LogRoleDeleted
{
    public function handle(RoleDeletedEvent $event): void
    {
        $causerName = $event->causer->name;

        activity('panel.role')
            ->causedBy($event->causer)
            ->event('deleted')
            ->withProperties([
                'role_name' => $event->roleName,
            ])
            ->log("{$causerName}, {$event->roleName} rolünü sildi.");
    }
}
