<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Mail\Auth\ResetPasswordMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    /**
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): ResetPasswordMail
    {
        $expire = (int) config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new ResetPasswordMail($this->resetUrl($notifiable), $expire))
            ->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'auth.password_reset_requested',
            'title' => __('Şifre sıfırlama bağlantısı gönderildi.'),
            'message' => __('Hesabınız için şifre sıfırlama bağlantısı e-posta adresinize gönderildi.'),
        ];
    }
}
