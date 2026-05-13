<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Members;

use App\Mail\Panel\Members\MemberEmailChangeRequestedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMemberEmailChangeRequestedMail implements ShouldQueue
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
            new MemberEmailChangeRequestedMail($this->user, $this->email, $this->confirmationUrl),
        );
    }
}
