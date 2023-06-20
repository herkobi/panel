<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

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
        $ip = request()->ip();
        activity()
            ->log($event->user->email . ' ' . $ip . ' adresi üzerinden başarılı bir şekilde oturum açtı');
        Log::info("{$event->user->email} {$ip} adresi üzerinden başarılı bir şekilde oturum açtı", ['id' => $event->user->id]);
        notyf()->addSuccess('Merhaba ' . $event->user->name);
    }
}
