<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LoginSuccesful
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        notyf()->addSuccess('Merhaba ' . $event->user->name);

        $ip = request()->ip();
        Log::info("{$event->user->email} {$ip} adresi üzerinden başarılı bir şekilde oturum açtı", ['id' => $event->user->id]);
    }
}
