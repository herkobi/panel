<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserEmailChangeConfirmedEvent;

class LogUserEmailChangeConfirmed
{
    public function handle(UserEmailChangeConfirmedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->newEmail;

        activity('settings.user')
            ->performedOn($event->user)
            ->causedBy($event->user)
            ->event('email_changed')
            ->withProperties([
                'user_id' => $event->user->id,
                'old_email' => $event->oldEmail,
                'new_email' => $event->newEmail,
            ])
            ->log("{$userLabel}, e-posta adresini {$event->oldEmail} → {$event->newEmail} olarak onayladı.");
    }
}
