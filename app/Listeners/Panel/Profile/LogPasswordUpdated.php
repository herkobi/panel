<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Events\Panel\Profile\PasswordUpdatedEvent;

class LogPasswordUpdated
{
    public function handle(PasswordUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;

        activity('profile')
            ->performedOn($event->updatedBy)
            ->causedBy($event->updatedBy)
            ->event('password_updated')
            ->log("{$userName}, profil şifresini güncelledi.");
    }
}
