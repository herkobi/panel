<?php

declare(strict_types=1);

namespace App\Notifications\Panel\Settings\User;

use App\Mail\Panel\Settings\User\UserWelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserWelcomeNotification extends Notification implements ShouldQueue
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

    public function toMail(object $notifiable): UserWelcomeMail
    {
        return (new UserWelcomeMail(
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
            'type' => 'users.welcome',
            'title' => __('Hesabınız oluşturuldu.'),
            'message' => __('Hesabınız oluşturuldu. Giriş yapabilmek için e-postanızdaki bağlantıyı kullanın.'),
        ];
    }
}
