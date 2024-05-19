<?php

namespace App\Listeners\Admin\Page;

use App\Events\Admin\Page\Updated as Event;
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
                    ? "{$user->name} {$user->surname} '{$oldTitle}' sayfanın adını '{$newTitle}' olarak değiştirdi."
                    : "{$user->name} {$user->surname} '{$oldTitle}' sayfa içeriğini güncelledi.";

        Log::info($description, [
            'page_id' => $event->newTitle->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
