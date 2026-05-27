<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Members;

use App\Mail\Panel\Members\MemberEmailChangeRequestedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MemberEmailChangeRequestedNotification extends Notification implements ShouldQueue
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

    public function toMail(object $notifiable): MemberEmailChangeRequestedMail
    {
        return (new MemberEmailChangeRequestedMail($notifiable, $this->email, $this->confirmationUrl))
            ->to($this->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'members.email_change_requested',
            'title' => __('E-posta değişikliği talep edildi.'),
            'message' => __('Yeni e-posta adresinize bir onay bağlantısı gönderildi.'),
        ];
    }
}
