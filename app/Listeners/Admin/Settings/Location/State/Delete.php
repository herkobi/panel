<?php

namespace App\Listeners\Admin\Settings\Location\State;

use App\Events\Admin\Settings\Location\State\Deleted as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Delete
{
    public function handle(Event $event)
    {
        $user = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        Log::info("State deleted by {$user->name}", [
            'tax_id' => $event->state,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
