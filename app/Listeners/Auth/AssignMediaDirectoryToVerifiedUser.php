<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Concerns\LogsActivity;
use App\Models\User;
use App\Services\Support\FileService;
use Illuminate\Auth\Events\Verified;

class AssignMediaDirectoryToVerifiedUser
{
    use LogsActivity;

    public function __construct(
        private readonly FileService $files,
    ) {}

    public function handle(Verified $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $directory = $this->files->ensureUserMediaCode($event->user);

        $this->logActivity(
            logName: 'auth',
            causer: $event->user,
            event: 'media_directory_assigned',
            message: 'Kullanıcı medya dizini atandı',
            subject: $event->user,
            properties: ['media_directory' => $directory],
        );
    }
}
