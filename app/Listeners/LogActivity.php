<?php
namespace App\Listeners;

use Illuminate\Auth\Events as LaravelEvents;

class LogActivity
{
    public function login(LaravelEvents\Login $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->user->email} logged in from {$ip}", $event->user->only('id', 'email'));
    }

    public function logout(LaravelEvents\Logout $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->user->email} logged out from {$ip}", $event->user->only('id', 'email'));
    }

    public function registered(LaravelEvents\Registered $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User registered: {$event->user->email} from {$ip}");
    }

    public function failed(LaravelEvents\Failed $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->credentials['email']} login failed from {$ip}", ['email' => $event->credentials['email']]);
    }

    public function passwordReset(LaravelEvents\PasswordReset $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->user->email} password reset from {$ip}", $event->user->only('id', 'email'));
    }

    protected function info(object $event, string $message, array $context = [])
    {
        //$class = class_basename($event::class);
        $class = get_class($event);

        info("[{$class}] {$message}", $context);
    }
}
