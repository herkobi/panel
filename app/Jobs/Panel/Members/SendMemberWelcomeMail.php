<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Members;

use App\Mail\Panel\Members\MemberWelcomeMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMemberWelcomeMail implements ShouldQueue
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
            new MemberWelcomeMail(
                $this->user,
                $this->welcomeUrl,
                $this->expireMinutes,
                $this->verifiesEmail,
            ),
        );
    }
}
