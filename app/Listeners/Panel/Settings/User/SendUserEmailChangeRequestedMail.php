<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserEmailChangeRequestedEvent;
use App\Notifications\Panel\Settings\User\UserEmailChangeRequestedNotification;
use Illuminate\Support\Facades\URL;

class SendUserEmailChangeRequestedMail
{
    public function handle(UserEmailChangeRequestedEvent $event): void
    {
        $confirmationUrl = URL::temporarySignedRoute(
            'panel.settings.users.email.confirm',
            now()->addDay(),
            [
                'user' => $event->user->id,
                'email' => $event->email,
            ],
        );

        $event->user->notify(new UserEmailChangeRequestedNotification(
            $event->email,
            $confirmationUrl,
        ));
    }
}
