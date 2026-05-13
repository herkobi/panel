<?php

declare(strict_types=1);

namespace App\Jobs\Panel\Members;

use App\Enums\UserStatus;
use App\Mail\Panel\Members\MemberStatusUpdatedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMemberStatusUpdatedMail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
        public readonly UserStatus $status,
    ) {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new MemberStatusUpdatedMail($this->user, $this->status));
    }
}
