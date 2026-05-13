<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserWelcomeAcceptedEvent;

class LogUserWelcomeAccepted
{
    public function handle(UserWelcomeAcceptedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('settings.user')
            ->performedOn($event->user)
            ->causedBy($event->user)
            ->event('welcome_accepted')
            ->withProperties([
                'user_id' => $event->user->id,
                'email_verified' => $event->emailVerified,
            ])
            ->log("{$userLabel}, hoş geldin bağlantısını açtı.");
    }
}
