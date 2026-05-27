<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Members;

use App\Mail\Panel\Members\MemberEmailVerifiedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MemberEmailVerifiedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MemberEmailVerifiedMail
    {
        return (new MemberEmailVerifiedMail($notifiable))->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'members.email_verified',
            'title' => __('E-posta adresiniz onaylandı.'),
            'message' => __('E-posta adresiniz başarıyla onaylandı.'),
        ];
    }
}
