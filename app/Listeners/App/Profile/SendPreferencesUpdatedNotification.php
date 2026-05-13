<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Events\App\Profile\PreferencesUpdatedEvent;
use App\Notifications\App\Profile\PreferencesUpdatedNotification;

class SendPreferencesUpdatedNotification
{
    public function handle(PreferencesUpdatedEvent $event): void
    {
        $event->updatedBy->notify(new PreferencesUpdatedNotification);
    }
}
