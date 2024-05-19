<?php

namespace App\Listeners\Admin\Settings\Tax;

use App\Events\Admin\Settings\Tax\Created as EventCreate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Create
{
    /**
     * Yeni bir vergi oluşturulduğunda tetiklenen olayın dinleyicisi.
     *
     * @param  EventCreate  $event
     * @return void
     */
    public function handle(EventCreate $event)
    {
        // Kullanıcı bilgilerini al
        $user = Auth::user();
        $time = Carbon::now()->toDateTimeString();
        $ipAddress = request()->ip();

        // Loglama işlemi
        Log::info("Tax created by {$user->name}", [
            'tax_id' => $event->tax->id,
            'user_id' => $user->id,
            'time' => $time,
            'ip_address' => $ipAddress
        ]);
    }
}
