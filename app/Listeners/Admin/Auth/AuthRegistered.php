<?php

namespace App\Listeners\Admin\Auth;

use Illuminate\Auth\Events\Registered as Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AuthRegistered
{
    public function handle(Event $event, ?array $context = null): void
    {
        if ($event instanceof Event) {

            DB::table('auth_logs')->insert([
                'event_name' => class_basename($event),
                'email' => $this->getEmailParameter($event),
                'user_id' => $this->getUserIdParameter($event),
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'context' => is_array($context) ? json_encode($context) : null,
                'created_at' => Carbon::now()->timezone(config('app.timezone', 'UTC')),
            ]);
        }
    }

    /** @param mixed $event */
    private function getEmailParameter($event): ?string
    {
        if (isset($event->credentials)) {
            return $event->credentials['email'] ?? null;
        }

        if (isset($event->request) && $event->request->has('email')) {
            return $event->request->email;
        }

        return null;
    }

    /** @param mixed $event */
    private function getUserIdParameter($event): ?string
    {
        if (isset($event->user)) {
            return $event->user->id;
        }

        if (Request::user()) {
            return Request::user()->id;
        }

        return null;
    }
}
