<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Mail\Auth\VerifyEmailMail;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): VerifyEmailMail
    {
        return (new VerifyEmailMail($this->verificationUrl($notifiable)))
            ->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'auth.email_verification_requested',
            'title' => __('E-posta doğrulama bağlantısı gönderildi.'),
            'message' => __('E-posta adresinizi doğrulamanız için yeni bir bağlantı gönderildi.'),
        ];
    }
}
