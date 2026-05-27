<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Members;

use App\Mail\Panel\Members\MemberWelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MemberWelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $welcomeUrl,
        public readonly int $expireMinutes,
        public readonly bool $verifiesEmail,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MemberWelcomeMail
    {
        return (new MemberWelcomeMail(
            $notifiable,
            $this->welcomeUrl,
            $this->expireMinutes,
            $this->verifiesEmail,
        ))->to($notifiable->email);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'members.welcome',
            'title' => __('Üyeliğiniz oluşturuldu.'),
            'message' => __('Hesabınız oluşturuldu. Giriş yapabilmek için e-postanızdaki bağlantıyı kullanın.'),
        ];
    }
}
