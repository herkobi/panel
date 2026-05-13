<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Enums\UserType;
use App\Models\User;
use App\Notifications\App\Profile\TwoFactorAuthenticationUpdatedNotification;
use Laravel\Fortify\Events\TwoFactorAuthenticationConfirmed;

class SendTwoFactorAuthenticationEnabledNotification
{
    public function handle(TwoFactorAuthenticationConfirmed $event): void
    {
        if (! $event->user instanceof User || $event->user->user_type !== UserType::Member) {
            return;
        }

        $event->user->notify(new TwoFactorAuthenticationUpdatedNotification(enabled: true));
    }
}
