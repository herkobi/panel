<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Settings\User;

use App\Mail\Panel\Settings\User\UserEmailVerifiedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserEmailVerifiedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): UserEmailVerifiedMail
    {
        return (new UserEmailVerifiedMail($notifiable))->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'users.email_verified',
            'title' => __('E-posta adresiniz onaylandı.'),
            'message' => __('E-posta adresiniz başarıyla onaylandı.'),
        ];
    }
}
