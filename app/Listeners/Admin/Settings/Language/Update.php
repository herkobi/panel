<?php

namespace App\Listeners\Admin\Settings\Language;

use App\Events\Admin\Settings\Language\Updated as Event;
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

        $oldTitle = $event->oldTitle->title;
        $newTitle = $event->newTitle->title;

        $description = ($oldTitle !== $newTitle)
                    ? "{$user->name} {$user->surname} '{$oldTitle}' olan dilin adını '{$newTitle}' olarak değiştirdi."
                    : "{$user->name} {$user->surname} '{$oldTitle}' dilinin bilgilerini güncelledi.";

        Log::info($description, [
            'language_id' => $event->newTitle->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
