<?php

declare(strict_types=1);

namespace App\Jobs\Auth;

use App\Events\Auth\NewDeviceLoginDetectedEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class DetectNewDeviceLogin implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly User $user,
        public readonly ?string $ipAddress,
        public readonly ?string $userAgent,
    ) {}

    public function handle(): void
    {
        if ($this->ipAddress === null) {
            return;
        }

        if (Carbon::parse($this->user->{$this->user->getCreatedAtColumn()})->diffInMinutes(now()) < 1) {
            return;
        }

        $query = $this->user
            ->authentications()
            ->where('ip_address', $this->ipAddress)
            ->when(
                $this->userAgent === null,
                fn ($query) => $query->whereNull('user_agent'),
                fn ($query) => $query->where('user_agent', $this->userAgent),
            );

        if ((clone $query)->count() !== 1) {
            return;
        }

        $authenticationLog = $query->first();

        NewDeviceLoginDetectedEvent::dispatch(
            $this->user,
            $this->ipAddress,
            $this->userAgent,
            $authenticationLog?->login_at?->toDateTimeString() ?? now()->toDateTimeString(),
        );
    }
}
