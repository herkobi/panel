<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserEmailChangeRequestedEvent;
use App\Jobs\Panel\Settings\User\SendUserEmailChangeRequestedMail as SendUserEmailChangeRequestedMailJob;
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

        SendUserEmailChangeRequestedMailJob::dispatch(
            $event->user,
            $event->email,
            $confirmationUrl,
        );
    }
}
