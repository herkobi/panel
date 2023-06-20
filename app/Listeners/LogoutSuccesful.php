<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class LogoutSuccesful
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
    public function handle(Logout $event): void
    {
        $ip = request()->ip();
        activity()
            ->log($event->user->email . ' ' . $ip . ' adresi üzerinden başarılı bir şekilde oturumunu kapattı');
        Log::info("{$event->user->email} {$ip} adresi üzerinden başarılı bir şekilde oturumunu kapattı", ['id' => $event->user->id]);
    }
}
