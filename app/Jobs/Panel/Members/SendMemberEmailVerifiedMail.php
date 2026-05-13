<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Members;

use App\Mail\Panel\Members\MemberEmailVerifiedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMemberEmailVerifiedMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
    ) {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new MemberEmailVerifiedMail($this->user));
    }
}
