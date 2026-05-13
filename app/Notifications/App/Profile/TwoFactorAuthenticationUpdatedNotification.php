<?php

declare(strict_types=1);

namespace App\Notifications\App\Profile;

use Illuminate\Notifications\Notification;

class TwoFactorAuthenticationUpdatedNotification extends Notification
{
    public function __construct(
        private readonly bool $enabled,
    ) {}

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
            'type' => $this->enabled ? 'profile.two_factor_enabled' : 'profile.two_factor_disabled',
            'title' => $this->enabled ? __('İki aşamalı doğrulama açıldı.') : __('İki aşamalı doğrulama kapatıldı.'),
            'message' => $this->enabled
                ? __('Hesabınız artık doğrulama kodu ile korunuyor.')
                : __('Hesabınız için iki aşamalı doğrulama devre dışı bırakıldı.'),
        ];
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }
}
