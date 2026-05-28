<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\User\UserCreatedEvent;

class LogUserCreated
{
    use LogsActivity;

    public function handle(UserCreatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'settings.user',
            subject: $event->user,
            causer: $event->causer,
            event: 'created',
            message: "{$causerName}, {$userLabel} panel kullanıcısını oluşturdu.",
            properties: [
                'user_id' => $event->user->id,
                'email_verified' => $event->emailVerified,
            ],
        );
    }
}
