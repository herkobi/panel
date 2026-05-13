<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Events\App\Profile\ProfileUpdatedEvent;
use App\Notifications\App\Profile\ProfileUpdatedNotification;

class SendProfileUpdatedNotification
{
    public function handle(ProfileUpdatedEvent $event): void
    {
        $event->updatedBy->notify(
            new ProfileUpdatedNotification(emailChanged: $event->emailChanged)
        );
    }
}
