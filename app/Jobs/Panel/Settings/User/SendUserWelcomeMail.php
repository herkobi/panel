<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Settings\User;

use App\Mail\Panel\Settings\User\UserWelcomeMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendUserWelcomeMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
        public readonly string $welcomeUrl,
        public readonly int $expireMinutes,
        public readonly bool $verifiesEmail,
    ) {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(
            new UserWelcomeMail(
                $this->user,
                $this->welcomeUrl,
                $this->expireMinutes,
                $this->verifiesEmail,
            ),
        );
    }
}
