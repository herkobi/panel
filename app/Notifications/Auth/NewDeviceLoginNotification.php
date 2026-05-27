<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Mail\Auth\NewDeviceLoginMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewDeviceLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $ipAddress,
        public readonly ?string $userAgent,
        public readonly string $loginAt,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): NewDeviceLoginMail
    {
        return (new NewDeviceLoginMail(
            ipAddress: $this->ipAddress,
            userAgent: $this->userAgent,
            loginAt: $this->loginAt,
        ))->to($notifiable->email);
    }

    /**
     * @return array<string, string|null>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'auth.new_device_login',
            'title' => __('Yeni cihazdan giriş yapıldı.'),
            'message' => __('Hesabınıza :ip adresinden, daha önce kullanılmayan bir cihazdan giriş yapıldı.', ['ip' => $this->ipAddress]),
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'login_at' => $this->loginAt,
        ];
    }
}
