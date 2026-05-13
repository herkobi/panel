<?php

declare(strict_types=1);

namespace App\Notifications\App\Profile;

use Illuminate\Notifications\Notification;

class PasswordUpdatedNotification extends Notification
{
    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'profile.password_updated',
            'title' => __('Şifreniz güncellendi.'),
            'message' => __('Güvenliğiniz için tüm cihazlardaki oturumlarınız kapatıldı.'),
        ];
    }
}
