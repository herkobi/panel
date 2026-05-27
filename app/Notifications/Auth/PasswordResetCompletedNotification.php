<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Mail\Auth\PasswordResetCompletedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PasswordResetCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): PasswordResetCompletedMail
    {
        return (new PasswordResetCompletedMail)
            ->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'auth.password_reset_completed',
            'title' => __('Şifreniz değiştirildi.'),
            'message' => __('Şifreniz başarıyla değiştirildi. Bu işlem size ait değilse hemen destek ekibiyle iletişime geçin.'),
        ];
    }
}
