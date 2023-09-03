<?php

namespace App\Listeners;

use App\Events\LogEvent;
use Illuminate\Support\Facades\Log;

class LogEventActivity
{
    public function handle(LogEvent $event)
    {
        Log::{$event->type}(
            __($event->model . '.log.' . $event->method . '.' . $event->status.'message', [
                'authuser' => auth()->user()->name,
                'ip' => request()->ip(),
                'name' => $event->data,
                'error' => $event->error
            ])
        );
    }
}
