<?php

namespace App\Listeners\Admin\Settings\Language;

use App\Events\Admin\Settings\Language\Created as Event;
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

        Log::info("Language created by {$user->name}", [
            'language_id' => $event->language->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
