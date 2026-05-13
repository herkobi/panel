<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Settings\User;

use App\Mail\Panel\Settings\User\UserEmailChangeRequestedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendUserEmailChangeRequestedMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
        public readonly string $email,
        public readonly string $confirmationUrl,
    ) {}

    public function handle(): void
    {
        Mail::to($this->email)->send(
            new UserEmailChangeRequestedMail($this->user, $this->email, $this->confirmationUrl),
        );
    }
}
