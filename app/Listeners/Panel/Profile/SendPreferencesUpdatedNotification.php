<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Events\Panel\Profile\PreferencesUpdatedEvent;
use App\Notifications\Panel\Profile\PreferencesUpdatedNotification;

class SendPreferencesUpdatedNotification
{
    public function handle(PreferencesUpdatedEvent $event): void
    {
        $event->updatedBy->notify(new PreferencesUpdatedNotification);
    }
}
