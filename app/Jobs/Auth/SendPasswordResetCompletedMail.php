<?php

declare(strict_types=1);

namespace App\Jobs\Auth;

use App\Models\User;
use App\Notifications\Auth\PasswordResetCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendPasswordResetCompletedMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
    ) {}

    public function handle(): void
    {
        $this->user->notify(new PasswordResetCompletedNotification);
    }
}
