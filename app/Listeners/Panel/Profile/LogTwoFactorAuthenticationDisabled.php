<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Concerns\LogsActivity;
use App\Enums\UserType;
use App\Models\User;
use Laravel\Fortify\Events\TwoFactorAuthenticationDisabled;

class LogTwoFactorAuthenticationDisabled
{
    use LogsActivity;

    public function handle(TwoFactorAuthenticationDisabled $event): void
    {
        if (! $event->user instanceof User || $event->user->user_type !== UserType::Admin) {
            return;
        }

        $userName = $event->user->name;

        $this->logActivity(
            logName: 'profile',
            subject: $event->user,
            causer: $event->user,
            event: 'two_factor_disabled',
            message: "{$userName}, iki aşamalı doğrulamayı kapattı.",
        );
    }
}
