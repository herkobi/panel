<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\User\UserWelcomeAcceptedEvent;

class LogUserWelcomeAccepted
{
    use LogsActivity;

    public function handle(UserWelcomeAcceptedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'settings.user',
            subject: $event->user,
            causer: $event->user,
            event: 'welcome_accepted',
            message: "{$userLabel}, hoş geldin bağlantısını açtı.",
            properties: [
                'user_id' => $event->user->id,
                'email_verified' => $event->emailVerified,
            ],
        );
    }
}
