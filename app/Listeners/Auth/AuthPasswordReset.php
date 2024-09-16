<?php

namespace App\Listeners\Auth;

use App\Models\Authlog;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset as Event;
use Illuminate\Support\Facades\Request;

class AuthPasswordReset
{
    public function handle(Event $event, ?array $context = null): void
    {
        if ($event instanceof Event) {

            $user = User::findOrFail($this->getUserIdParameter($event));
            Authlog::create([
                'event_name' => class_basename($event),
                'email' => $this->getEmailParameter($event),
                'user_id' => $this->getUserIdParameter($event),
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'context' => is_array($context) ? json_encode($context) : null,
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
