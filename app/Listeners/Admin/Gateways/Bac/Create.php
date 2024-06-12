<?php

namespace App\Listeners\Admin\Gateways\Bac;

use App\Events\Admin\Gateways\Bac\Created as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Create
{
    public function handle(Event $event)
    {
        $user = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        Log::info("Bac created by {$user->name}", [
            'gateway_id' => $event->gateway->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
