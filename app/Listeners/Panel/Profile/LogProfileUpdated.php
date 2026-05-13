<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Events\Panel\Profile\ProfileUpdatedEvent;

class LogProfileUpdated
{
    public function handle(ProfileUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;
        $message = $event->emailChanged
            ? "{$userName}, profil e-posta adresini güncelledi."
            : "{$userName}, profil bilgilerini güncelledi.";

        activity('profile')
            ->performedOn($event->updatedBy)
            ->causedBy($event->updatedBy)
            ->event($event->emailChanged ? 'email_updated' : 'updated')
            ->log($message);
    }
}
