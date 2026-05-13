<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Settings\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Yadahan\AuthenticationLog\AuthenticationLog;

/**
 * @mixin AuthenticationLog
 */
class UserSessionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'device' => $this->deviceName(),
            'browser' => $this->browserName(),
            'platform' => $this->platformName(),
            'login_at' => $this->login_at,
            'logout_at' => $this->logout_at,
        ];
    }

    private function deviceName(): string
    {
        $userAgent = (string) $this->user_agent;

        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent) === 1) {
            return 'Mobil cihaz';
        }

        return 'Masaüstü';
    }

    private function browserName(): string
    {
        $userAgent = (string) $this->user_agent;

        return match (true) {
            str_contains($userAgent, 'Edg/') => 'Microsoft Edge',
            str_contains($userAgent, 'Chrome/') => 'Google Chrome',
            str_contains($userAgent, 'Firefox/') => 'Mozilla Firefox',
            str_contains($userAgent, 'Safari/') => 'Safari',
            default => 'Bilinmeyen tarayıcı',
        };
    }

    private function platformName(): string
    {
        $userAgent = (string) $this->user_agent;

        return match (true) {
            str_contains($userAgent, 'Windows') => 'Windows',
            str_contains($userAgent, 'Macintosh') || str_contains($userAgent, 'Mac OS') => 'macOS',
            str_contains($userAgent, 'Linux') => 'Linux',
            str_contains($userAgent, 'Android') => 'Android',
            str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad') => 'iOS',
            default => 'Bilinmeyen platform',
        };
    }
}
