<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Profile;

use Illuminate\Notifications\Notification;

class SessionRevokedNotification extends Notification
{
    public function __construct(
        public readonly ?string $ipAddress = null,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, string|null>
     */
    public function toArray(object $notifiable): array
    {
        $ip = $this->ipAddress ?? 'bilinmeyen IP';

        return [
            'type' => 'profile.session_revoked',
            'title' => __('Oturum kapatıldı.'),
            'message' => __(':ip adresindeki aktif oturum kapatıldı.', ['ip' => $ip]),
            'ip_address' => $this->ipAddress,
        ];
    }
}
