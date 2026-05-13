<?php

declare(strict_types=1);

namespace App\Notifications\Auth;

use App\Jobs\Auth\SendNewDeviceLoginMail;
use App\Models\User;
use Illuminate\Notifications\Notification;

class NewDeviceLoginNotification extends Notification
{
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
        return ['database'];
    }

    public function dispatchMail(User $user): void
    {
        SendNewDeviceLoginMail::dispatch(
            $user,
            $this->ipAddress,
            $this->userAgent,
            $this->loginAt,
        );
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
