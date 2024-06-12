<?php

namespace App\Listeners\Admin\Settings\Location\Country;

use App\Events\Admin\Settings\Location\Country\Updated as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Update
{
    public function handle(Event $event)
    {
        $user = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        Log::info("Country updated by {$user->name}", [
            'tax_id' => $event->country->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
