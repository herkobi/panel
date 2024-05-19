<?php

namespace App\Listeners\Admin\Settings\Currency;

use App\Events\Admin\Settings\Currency\Created as Event;
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

        Log::info("Currency created by {$user->name}", [
            'currency_id' => $event->currency->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
