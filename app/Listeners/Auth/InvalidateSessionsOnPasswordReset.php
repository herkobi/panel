<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvalidateSessionsOnPasswordReset
{
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        if (! $user instanceof User) {
            return;
        }

        $user->forceFill([
            'remember_token' => Str::random(60),
        ])->save();

        if (config('session.driver') === 'database') {
            DB::table(config('session.table', 'sessions'))
                ->where('user_id', $user->getKey())
                ->delete();
        }
    }
}
