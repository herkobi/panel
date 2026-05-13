<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Events\App\Profile\PasswordUpdatedEvent;
use App\Notifications\App\Profile\PasswordUpdatedNotification;

class SendPasswordUpdatedNotification
{
    public function handle(PasswordUpdatedEvent $event): void
    {
        $event->updatedBy->notify(new PasswordUpdatedNotification);
    }
}
