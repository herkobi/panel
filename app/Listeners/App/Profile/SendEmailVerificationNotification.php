<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Events\App\Profile\ProfileUpdatedEvent;
use App\Jobs\App\Profile\SendEmailVerificationMail;

class SendEmailVerificationNotification
{
    public function handle(ProfileUpdatedEvent $event): void
    {
        if (! $event->emailChanged) {
            return;
        }

        SendEmailVerificationMail::dispatch($event->updatedBy);
    }
}
