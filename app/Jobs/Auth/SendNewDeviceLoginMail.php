<?php

declare(strict_types=1);

namespace App\Jobs\Auth;

use App\Mail\Auth\NewDeviceLoginMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewDeviceLoginMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
        public readonly string $ipAddress,
        public readonly ?string $userAgent,
        public readonly string $loginAt,
    ) {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new NewDeviceLoginMail(
            ipAddress: $this->ipAddress,
            userAgent: $this->userAgent,
            loginAt: $this->loginAt,
        ));
    }
}
