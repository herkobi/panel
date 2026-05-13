<?php

declare(strict_types=1);

namespace App\Mail\Panel\Settings\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserEmailChangeRequestedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $email,
        public readonly string $confirmationUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').' — E-posta Değişikliği Onayı',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.panel.settings.users.email-change-requested',
            with: [
                'user' => $this->user,
                'email' => $this->email,
                'confirmationUrl' => $this->confirmationUrl,
            ],
        );
    }
}
