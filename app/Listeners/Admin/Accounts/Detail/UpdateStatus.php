<?php

namespace App\Listeners\Admin\Accounts\Detail;

use App\Events\Admin\Accounts\Detail\UpdatedStatus as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UpdateStatus
{
    public function handle(Event $event)
    {
        $auth = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        Log::info("Status changed by {$auth->name}", [
            'user_id' => $event->user->id,
            'user_id' => $auth->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}