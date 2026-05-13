<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Events\App\Profile\SessionRevokedEvent;

class LogSessionRevoked
{
    public function handle(SessionRevokedEvent $event): void
    {
        $userName = $event->updatedBy->name;
        $ip = $event->ipAddress ?? 'bilinmeyen IP';

        activity('profile')
            ->performedOn($event->updatedBy)
            ->causedBy($event->updatedBy)
            ->event('session_revoked')
            ->withProperties([
                'ip_address' => $event->ipAddress,
                'user_agent' => $event->userAgent,
            ])
            ->log("{$userName}, {$ip} adresindeki aktif oturumu kapattı.");
    }
}
