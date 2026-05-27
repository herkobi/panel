<?php

declare(strict_types=1);

namespace App\Services\Support;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public const PUBLIC_DISK = 'public';

    public const PRIVATE_DISK = 'private';

    public function storePublicImage(
        UploadedFile $file,
        string $directory,
        ?string $oldPath = null,
        ?string $prefix = null,
    ): string {
        $filename = Str::slug($prefix ?: 'image')
            .'-'.Str::uuid()->toString()
            .'.'.$file->extension();

        $path = $file->storeAs($directory, $filename, self::PUBLIC_DISK);

        if ($oldPath !== null && $oldPath !== $path) {
            $this->deletePublicFile($oldPath);
        }

        return $path;
    }

    public function deletePublicFile(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }

        Storage::disk(self::PUBLIC_DISK)->delete($path);
    }

    public function publicUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        return Storage::disk(self::PUBLIC_DISK)->url($path);
    }

    public function storePrivateFile(
        UploadedFile $file,
        string $directory,
        ?string $oldPath = null,
        ?string $prefix = null,
    ): string {
        $filename = Str::slug($prefix ?: 'file')
            .'-'.Str::uuid()->toString()
            .'.'.$file->extension();

        $path = $file->storeAs($directory, $filename, self::PRIVATE_DISK);

        if ($oldPath !== null && $oldPath !== $path) {
            $this->deletePrivateFile($oldPath);
        }

        return $path;
    }

    public function deletePrivateFile(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }

        Storage::disk(self::PRIVATE_DISK)->delete($path);
    }

    public function privateExists(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        return Storage::disk(self::PRIVATE_DISK)->exists($path);
    }

    public function ensureUserMediaCode(User $user): string
    {
        if (is_string($user->media_directory) && $user->media_directory !== '') {
            return $user->media_directory;
        }

        $code = $this->uniqueUserMediaCode();

        $user->forceFill(['media_directory' => $code])->save();

        return $code;
    }

    public function ensureUserPublicDirectory(User $user): string
    {
        $directory = 'users/'.$this->ensureUserMediaCode($user);

        Storage::disk(self::PUBLIC_DISK)->makeDirectory($directory);

        return $directory;
    }

    private function uniqueUserMediaCode(): string
    {
        do {
            $code = Str::lower(Str::random(9));
        } while (User::query()->where('media_directory', $code)->exists());

        return $code;
    }
}
