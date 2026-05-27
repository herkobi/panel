<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Settings\User;

use App\Mail\Panel\Settings\User\UserEmailChangeRequestedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserEmailChangeRequestedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $email,
        public readonly string $confirmationUrl,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): UserEmailChangeRequestedMail
    {
        return (new UserEmailChangeRequestedMail($notifiable, $this->email, $this->confirmationUrl))
            ->to($this->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'users.email_change_requested',
            'title' => __('E-posta değişikliği talep edildi.'),
            'message' => __('Yeni e-posta adresinize bir onay bağlantısı gönderildi.'),
        ];
    }
}
