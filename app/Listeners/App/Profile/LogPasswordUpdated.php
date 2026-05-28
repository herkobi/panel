<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Concerns\LogsActivity;
use App\Events\App\Profile\PasswordUpdatedEvent;

class LogPasswordUpdated
{
    use LogsActivity;

    public function handle(PasswordUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;

        $this->logActivity(
            logName: 'profile',
            subject: $event->updatedBy,
            causer: $event->updatedBy,
            event: 'password_updated',
            message: "{$userName}, profil şifresini güncelledi.",
        );
    }
}
