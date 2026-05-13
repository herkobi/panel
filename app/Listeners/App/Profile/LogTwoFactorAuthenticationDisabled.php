<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Enums\UserType;
use App\Models\User;
use Laravel\Fortify\Events\TwoFactorAuthenticationDisabled;

class LogTwoFactorAuthenticationDisabled
{
    public function handle(TwoFactorAuthenticationDisabled $event): void
    {
        if (! $event->user instanceof User || $event->user->user_type !== UserType::Member) {
            return;
        }

        $userName = $event->user->name;

        activity('profile')
            ->performedOn($event->user)
            ->causedBy($event->user)
            ->event('two_factor_disabled')
            ->log("{$userName}, iki aşamalı doğrulamayı kapattı.");
    }
}
