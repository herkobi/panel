<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Events\App\Profile\PreferencesUpdatedEvent;

class LogPreferencesUpdated
{
    public function handle(PreferencesUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;

        activity('profile')
            ->performedOn($event->updatedBy)
            ->causedBy($event->updatedBy)
            ->event('preferences_updated')
            ->log("{$userName}, profil tercihlerini güncelledi.");
    }
}
