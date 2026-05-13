<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Settings\User;

use App\Mail\Panel\Settings\User\UserEmailVerifiedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendUserEmailVerifiedMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
    ) {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new UserEmailVerifiedMail($this->user));
    }
}
