<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Settings\User;

use App\Enums\UserStatus;
use App\Mail\Panel\Settings\User\UserStatusUpdatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly UserStatus $status,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): UserStatusUpdatedMail
    {
        return (new UserStatusUpdatedMail($notifiable, $this->status))->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'users.status_updated',
            'title' => __('Hesap durumunuz güncellendi.'),
            'message' => __('Hesap durumunuz güncellendi.'),
        ];
    }
}
