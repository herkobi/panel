<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Enums\UserType;
use App\Models\User;
use App\Notifications\Panel\Profile\TwoFactorAuthenticationUpdatedNotification;
use Laravel\Fortify\Events\TwoFactorAuthenticationDisabled;

class SendTwoFactorAuthenticationDisabledNotification
{
    public function handle(TwoFactorAuthenticationDisabled $event): void
    {
        if (! $event->user instanceof User || $event->user->user_type !== UserType::Admin) {
            return;
        }

        $event->user->notify(new TwoFactorAuthenticationUpdatedNotification(enabled: false));
    }
}
