<?php

declare(strict_types=1);

namespace App\Jobs\Auth;

use App\Models\User;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendPasswordResetMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
        public readonly string $token,
    ) {}

    public function handle(): void
    {
        $this->user->notify(new ResetPasswordNotification($this->token));
    }
}
