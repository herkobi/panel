<?php

declare(strict_types=1);

namespace App\Notifications\App\Profile;

use Illuminate\Notifications\Notification;

class PreferencesUpdatedNotification extends Notification
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
            'type' => 'profile.preferences_updated',
            'title' => __('Tercihleriniz güncellendi.'),
            'message' => __('Arayüz dili veya zaman dilimi tercihleriniz başarıyla güncellendi.'),
        ];
    }
}
