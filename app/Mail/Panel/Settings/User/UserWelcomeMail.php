<?php

declare(strict_types=1);

namespace App\Mail\Panel\Settings\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserWelcomeMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $welcomeUrl,
        public readonly int $expireMinutes,
        public readonly bool $verifiesEmail,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').' — Panel Hesabınız Oluşturuldu',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.panel.settings.users.welcome',
            with: [
                'user' => $this->user,
                'welcomeUrl' => $this->welcomeUrl,
                'expireMinutes' => $this->expireMinutes,
                'verifiesEmail' => $this->verifiesEmail,
            ],
        );
    }
}
