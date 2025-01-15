<?php

namespace App\Listeners\Admin\Tools;

use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Activity;
use App\Models\User;

class PasswordResetRequest
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  PasswordResetLinkSent  $event
     * @return void
     */
    public function handle(PasswordResetLinkSent $event)
    {
        $user = User::where('email', $event->user->email)->first();

        Activity::create([
            'user_id' => $user->id,
            'message' => 'password',
            'log' => json_encode([
                'action' => 'password reset requested',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
