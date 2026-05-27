<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Events\Panel\Profile\ProfileUpdatedEvent;
use App\Notifications\Auth\VerifyEmailNotification;

class SendEmailVerificationNotification
{
    public function handle(ProfileUpdatedEvent $event): void
    {
        if (! $event->emailChanged) {
            return;
        }

        $event->updatedBy->notify(new VerifyEmailNotification);
    }
}
