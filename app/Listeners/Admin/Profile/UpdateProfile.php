<?php

namespace App\Listeners\Admin\Profile;

use App\Events\Admin\Profile\UpdatedProfile as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UpdateProfile
{
    public function handle(Event $event)
    {
        $auth = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        Log::info("{$auth->name} updated profile", [
            'user_id' => $event->user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
