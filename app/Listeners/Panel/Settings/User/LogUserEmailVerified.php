<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserEmailVerifiedEvent;

class LogUserEmailVerified
{
    public function handle(UserEmailVerifiedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('settings.user')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('email_verified')
            ->withProperties(['user_id' => $event->user->id])
            ->log("{$causerName}, {$userLabel} panel kullanıcısının e-posta adresini onayladı.");
    }
}
