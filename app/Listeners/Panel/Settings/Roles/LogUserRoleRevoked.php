<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\Roles\UserRoleRevokedEvent;

class LogUserRoleRevoked
{
    use LogsActivity;

    public function handle(UserRoleRevokedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'panel.role',
            subject: $event->user,
            causer: $event->causer,
            event: 'role_revoked',
            message: "{$causerName}, {$userLabel} kullanıcısının {$event->roleName} rolünü kaldırdı.",
            properties: [
                'user_id' => $event->user->getKey(),
                'role_name' => $event->roleName,
            ],
        );
    }
}
