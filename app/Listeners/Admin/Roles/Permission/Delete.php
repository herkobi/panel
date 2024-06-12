<?php

namespace App\Listeners\Admin\Roles\Permission;

use App\Events\Admin\Roles\Permission\Deleted as Event;
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

        Log::info("Permission deleted by {$user->name}", [
            'permission_id' => $event->permission,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
