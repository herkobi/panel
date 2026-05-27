<?php

declare(strict_types=1);

namespace App\Services\Support;

use App\Concerns\HasMedia;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class MediaService
{
    public function __construct(
        private readonly FileService $files,
    ) {}

    public function attach(
        Model $owner,
        UploadedFile $file,
        string $collection = 'default',
        bool $private = true,
    ): Media {
        $this->ensureHasMedia($owner);

        return DB::transaction(function () use ($owner, $file, $collection, $private) {
            $disk = $private ? FileService::PRIVATE_DISK : FileService::PUBLIC_DISK;

            $path = $private
                ? $this->files->storePrivateFile($file, $owner->mediaDirectory(), prefix: $collection)
                : $this->files->storePublicImage($file, $owner->mediaDirectory(), prefix: $collection);

            return Media::create([
                'mediable_type' => $owner->getMorphClass(),
                'mediable_id' => $owner->getKey(),
                'disk' => $disk,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'collection' => $collection,
                'sort_order' => $this->nextSortOrder($owner, $collection),
            ]);
        });
    }

    public function detach(Media $media): void
    {
        DB::transaction(function () use ($media) {
            if ($media->disk === FileService::PUBLIC_DISK) {
                $this->files->deletePublicFile($media->path);
            } else {
                $this->files->deletePrivateFile($media->path);
            }

            $media->delete();
        });
    }

    /**
     * @param  array<int, string>  $orderedIds
     */
    public function reorder(Model $owner, string $collection, array $orderedIds): void
    {
        $this->ensureHasMedia($owner);

        DB::transaction(function () use ($owner, $collection, $orderedIds) {
            foreach ($orderedIds as $index => $id) {
                Media::query()
                    ->where('mediable_type', $owner->getMorphClass())
                    ->where('mediable_id', $owner->getKey())
                    ->where('collection', $collection)
                    ->whereKey($id)
                    ->update(['sort_order' => $index]);
            }
        });
    }

    private function nextSortOrder(Model $owner, string $collection): int
    {
        return (int) Media::query()
            ->where('mediable_type', $owner->getMorphClass())
            ->where('mediable_id', $owner->getKey())
            ->where('collection', $collection)
            ->max('sort_order') + 1;
    }

    private function ensureHasMedia(Model $owner): void
    {
        if (! in_array(HasMedia::class, class_uses_recursive($owner), true)) {
            throw new InvalidArgumentException(
                $owner::class.' must use the HasMedia trait.',
            );
        }
    }
}
