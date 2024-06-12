<?php

namespace App\Listeners\Admin\Settings\Location\State;

use App\Events\Admin\Settings\Location\State\Created as Event;
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

        Log::info("State created by {$user->name}", [
            'tax_id' => $event->state->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
