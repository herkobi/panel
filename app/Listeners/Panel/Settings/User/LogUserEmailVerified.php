<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Concerns\LogsActivity;
use App\Events\Panel\Settings\User\UserEmailVerifiedEvent;

class LogUserEmailVerified
{
    use LogsActivity;

    public function handle(UserEmailVerifiedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'settings.user',
            subject: $event->user,
            causer: $event->causer,
            event: 'email_verified',
            message: "{$causerName}, {$userLabel} panel kullanıcısının e-posta adresini onayladı.",
            properties: ['user_id' => $event->user->id],
        );
    }
}
