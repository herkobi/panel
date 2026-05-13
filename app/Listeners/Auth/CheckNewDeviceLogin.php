<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Jobs\Auth\DetectNewDeviceLogin;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class CheckNewDeviceLogin
{
    public function __construct(
        private readonly Request $request,
    ) {}

    public function handle(Login $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        DetectNewDeviceLogin::dispatchAfterResponse(
            $event->user,
            $this->request->ip(),
            $this->request->userAgent(),
        );
    }
}
