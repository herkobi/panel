<?php

namespace App\Listeners\Admin\Gateways\Bac;

use App\Events\Admin\Gateways\Bac\Updated as Event;
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
                    ? "{$user->name} {$user->surname} '{$oldTitle}' eft/havele ile ödeme sisteminin '{$newTitle}' olarak değiştirdi."
                    : "{$user->name} {$user->surname} '{$oldTitle}' isimli eft/havale ödeme sisteminin bilgilerini güncelledi.";

        Log::info($description, [
            'gateway_id' => $event->newTitle->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
