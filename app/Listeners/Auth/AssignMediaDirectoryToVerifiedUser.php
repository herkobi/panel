<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\User;
use App\Services\Support\FileService;
use Illuminate\Auth\Events\Verified;

class AssignMediaDirectoryToVerifiedUser
{
    public function __construct(
        private readonly FileService $files,
    ) {}

    public function handle(Verified $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $directory = $this->files->ensureUserMediaCode($event->user);

        activity('auth')
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->event('media_directory_assigned')
            ->withProperties(['media_directory' => $directory])
            ->log('Kullanıcı medya dizini atandı');
    }
}
