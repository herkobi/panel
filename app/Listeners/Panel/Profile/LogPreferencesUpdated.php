<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Concerns\LogsActivity;
use App\Events\Panel\Profile\PreferencesUpdatedEvent;

class LogPreferencesUpdated
{
    use LogsActivity;

    public function handle(PreferencesUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;

        $this->logActivity(
            logName: 'profile',
            subject: $event->updatedBy,
            causer: $event->updatedBy,
            event: 'preferences_updated',
            message: "{$userName}, profil tercihlerini güncelledi.",
        );
    }
}
