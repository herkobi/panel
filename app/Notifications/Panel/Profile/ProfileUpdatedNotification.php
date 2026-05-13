<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Profile;

use Illuminate\Notifications\Notification;

class ProfileUpdatedNotification extends Notification
{
    public function __construct(
        private readonly bool $emailChanged = false,
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
            'type' => $this->emailChanged ? 'profile.email_updated' : 'profile.updated',
            'title' => $this->emailChanged ? __('E-posta adresiniz güncellendi.') : __('Profil bilgileriniz güncellendi.'),
            'message' => $this->emailChanged
                ? __('Yeni e-posta adresinizi doğrulamanız gerekiyor.')
                : __('Profil bilgileriniz başarıyla güncellendi.'),
        ];
    }

    public function emailChanged(): bool
    {
        return $this->emailChanged;
    }
}
