<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\User\UserEmailChangeRequestedEvent;

class LogUserEmailChangeRequested
{
    use LogsActivity;

    public function handle(UserEmailChangeRequestedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'settings.user',
            subject: $event->user,
            causer: $event->causer,
            event: 'email_change_requested',
            message: "{$causerName}, {$userLabel} panel kullanıcısının e-posta adresini {$event->user->email} → {$event->email} olarak değiştirmek için talep oluşturdu.",
            properties: [
                'user_id' => $event->user->id,
                'old_email' => $event->user->email,
                'new_email' => $event->email,
            ],
        );
    }
}
