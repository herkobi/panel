<?php

declare(strict_types=1);

namespace App\Mail\Panel\Members;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberStatusUpdatedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly UserStatus $status,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').' — Üyelik Durumunuz Güncellendi',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.panel.members.status-updated',
            with: [
                'user' => $this->user,
                'status' => $this->status,
            ],
        );
    }
}
