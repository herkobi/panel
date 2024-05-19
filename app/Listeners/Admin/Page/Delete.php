<?php

namespace App\Listeners\Admin\Page;

use App\Events\Admin\Page\Deleted as Event;
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

        $description = "{$user->name} {$user->surname} {$event->page->title} isimli sayfayı sildi.";
        Log::info($description, [
            'page_id' => $event->page->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
