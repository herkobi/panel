<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Events\Panel\Profile\ProfileUpdatedEvent;
use App\Notifications\Panel\Profile\ProfileUpdatedNotification;

class SendProfileUpdatedNotification
{
    public function handle(ProfileUpdatedEvent $event): void
    {
        $event->updatedBy->notify(
            new ProfileUpdatedNotification(emailChanged: $event->emailChanged)
        );
    }
}
