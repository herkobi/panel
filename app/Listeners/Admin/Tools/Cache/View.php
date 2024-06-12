<?php

namespace App\Listeners\Admin\Tools\Cache;

use App\Events\Admin\Tools\Cache\View as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class View
{
    public function handle(Event $event)
    {
        $user = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        Log::info("View cache cleared by {$user->name}", [
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
