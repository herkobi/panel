<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\User\UserStatusUpdatedEvent;

class LogUserStatusUpdated
{
    use LogsActivity;

    public function handle(UserStatusUpdatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'settings.user',
            subject: $event->user,
            causer: $event->causer,
            event: 'status_updated',
            message: "{$causerName}, {$userLabel} panel kullanıcısının durumunu {$event->oldStatus->value} → {$event->newStatus->value} olarak değiştirdi.",
            properties: [
                'user_id' => $event->user->id,
                'old_status' => $event->oldStatus->value,
                'new_status' => $event->newStatus->value,
            ],
        );
    }
}
