<?php

namespace App\Listeners\Admin\Settings\Tax;

use App\Events\Admin\Settings\Tax\Deleted as Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Delete
{
    /**
     * Bir vergi silindiğinde tetiklenen olayın dinleyicisi.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
        // Kullanıcı bilgilerini al
        $user = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        // Loglama işlemi
        Log::info("Tax deleted by {$user->name}", [
            'tax_id' => $event->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
