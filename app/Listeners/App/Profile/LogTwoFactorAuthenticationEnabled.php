<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Concerns\LogsActivity;
use App\Enums\UserType;
use App\Models\User;
use Laravel\Fortify\Events\TwoFactorAuthenticationConfirmed;

class LogTwoFactorAuthenticationEnabled
{
    use LogsActivity;

    public function handle(TwoFactorAuthenticationConfirmed $event): void
    {
        if (! $event->user instanceof User || $event->user->user_type !== UserType::Member) {
            return;
        }

        $userName = $event->user->name;

        $this->logActivity(
            logName: 'profile',
            subject: $event->user,
            causer: $event->user,
            event: 'two_factor_enabled',
            message: "{$userName}, iki aşamalı doğrulamayı açtı.",
        );
    }
}
