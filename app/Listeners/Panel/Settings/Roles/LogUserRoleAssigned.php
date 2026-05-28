<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\Roles;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\Roles\UserRoleAssignedEvent;

class LogUserRoleAssigned
{
    use LogsActivity;

    public function handle(UserRoleAssignedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;
        $message = $event->previousRoleName !== null
            ? "{$causerName}, {$userLabel} kullanıcısının rolünü {$event->previousRoleName} → {$event->roleName} olarak değiştirdi."
            : "{$causerName}, {$userLabel} kullanıcısına {$event->roleName} rolünü atadı.";

        $this->logActivity(
            logName: 'panel.role',
            subject: $event->user,
            causer: $event->causer,
            event: 'role_assigned',
            message: $message,
            properties: [
                'user_id' => $event->user->getKey(),
                'role_name' => $event->roleName,
                'previous_role_name' => $event->previousRoleName,
            ],
        );
    }
}
