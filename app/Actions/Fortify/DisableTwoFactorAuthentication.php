<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Actions\DisableTwoFactorAuthentication as ActionsDisableTwoFactorAuthentication;

class DisableTwoFactorAuthentication extends ActionsDisableTwoFactorAuthentication
{
    /**
     * Disable two factor authentication for the user.
     * This is identical to the Action from Fortify except that it also sets two_factor_confirmed to 0
     *
     * @param  mixed  $user
     * @return void
     */
    public function __invoke($user)
    {
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null
        ])->save();
    }
}
