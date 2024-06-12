<?php

namespace App\Listeners\Admin\Settings\Settings;

use App\Events\Admin\Settings\Settings\SystemUpdated as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SystemUpdate
{
    public function handle(Event $event)
    {
        $user = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        Log::info("System settings updated by {$user->name}", [
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
