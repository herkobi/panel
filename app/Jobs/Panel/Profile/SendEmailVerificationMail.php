<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Profile;

use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendEmailVerificationMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
    ) {}

    public function handle(): void
    {
        $this->user->notify(new VerifyEmailNotification);
    }
}
