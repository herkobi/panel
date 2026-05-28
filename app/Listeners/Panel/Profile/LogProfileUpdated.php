<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Concerns\LogsActivity;
use App\Events\Panel\Profile\ProfileUpdatedEvent;

class LogProfileUpdated
{
    use LogsActivity;

    public function handle(ProfileUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;
        $message = $event->emailChanged
            ? "{$userName}, e-posta adresini güncelledi."
            : "{$userName}, bilgilerini güncelledi.";

        $this->logActivity(
            logName: 'profile',
            subject: $event->updatedBy,
            causer: $event->updatedBy,
            event: $event->emailChanged ? 'email_updated' : 'updated',
            message: $message,
        );
    }
}
