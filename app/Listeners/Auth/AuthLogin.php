<?php

namespace App\Listeners\Auth;

use App\Models\Authlog;
use App\Models\User;
use Illuminate\Auth\Events\Login as Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class AuthLogin
{
    public function handle(Event $event, ?array $context = null): void
    {
        if ($event instanceof Event) {

            $user = User::findOrFail($this->getUserIdParameter($event));
            $agent = new Agent();
            $device = $agent->device();
            $browser = $agent->browser();
            $browser_version = $agent->version($browser);
            $os = $agent->platform();
            $os_version = $agent->version($os);
            $language = $agent->languages();

            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => Request::ip(),
                'agent' => json_encode([
                    'device' => $device,
                    'os' => $os,
                    'os_version' => $os_version,
                    'browser' => $browser,
                    'browser_version' => $browser_version,
                    'language' => implode(',', $language)
                ]),
            ]);

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
