<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Members;

use App\Enums\UserStatus;
use App\Mail\Panel\Members\MemberStatusUpdatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MemberStatusUpdatedNotification extends Notification implements ShouldQueue
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

    public function toMail(object $notifiable): MemberStatusUpdatedMail
    {
        return (new MemberStatusUpdatedMail($notifiable, $this->status))->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'members.status_updated',
            'title' => __('Üyelik durumunuz güncellendi.'),
            'message' => __('Üyelik durumunuz güncellendi.'),
        ];
    }
}
