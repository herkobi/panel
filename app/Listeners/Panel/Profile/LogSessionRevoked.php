<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Concerns\LogsActivity;
use App\Events\Panel\Profile\SessionRevokedEvent;

class LogSessionRevoked
{
    use LogsActivity;

    public function handle(SessionRevokedEvent $event): void
    {
        $userName = $event->updatedBy->name;
        $ip = $event->ipAddress ?? 'bilinmeyen IP';

        $this->logActivity(
            logName: 'profile',
            subject: $event->updatedBy,
            causer: $event->updatedBy,
            event: 'session_revoked',
            message: "{$userName}, {$ip} adresindeki aktif oturumu kapattı.",
            properties: [
                'ip_address' => $event->ipAddress,
                'user_agent' => $event->userAgent,
            ],
        );
    }
}
