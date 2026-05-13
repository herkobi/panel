<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserEmailChangeRequestedEvent;

class LogUserEmailChangeRequested
{
    public function handle(UserEmailChangeRequestedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('settings.user')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('email_change_requested')
            ->withProperties([
                'user_id' => $event->user->id,
                'old_email' => $event->user->email,
                'new_email' => $event->email,
            ])
            ->log("{$causerName}, {$userLabel} panel kullanıcısının e-posta adresini {$event->user->email} → {$event->email} olarak değiştirmek için talep oluşturdu.");
    }
}
