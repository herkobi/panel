<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Events\Panel\Settings\Roles\UserRoleRevokedEvent;

class LogUserRoleRevoked
{
    public function handle(UserRoleRevokedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('panel.role')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('role_revoked')
            ->withProperties([
                'user_id' => $event->user->getKey(),
                'role_name' => $event->roleName,
            ])
            ->log("{$causerName}, {$userLabel} kullanıcısının {$event->roleName} rolünü kaldırdı.");
    }
}
