<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserCreatedEvent;

class LogUserCreated
{
    public function handle(UserCreatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('settings.user')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('created')
            ->withProperties([
                'user_id' => $event->user->id,
                'email_verified' => $event->emailVerified,
            ])
            ->log("{$causerName}, {$userLabel} panel kullanıcısını oluşturdu.");
    }
}
