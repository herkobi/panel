<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasSortOrder;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'mediable_type',
    'mediable_id',
    'disk',
    'path',
    'original_name',
    'mime_type',
    'size',
    'collection',
    'sort_order',
    'custom_properties',
])]
class Media extends Model
{
    use HasFactory, HasSortOrder, HasUuids;

    protected $table = 'media';

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            // Uygulamaya özel metadata torbası. Anlamı tüketen sisteme aittir:
            // örn. ['alt' => '...', 'is_cover' => true, 'focal' => [x, y]].
            // Hiçbir alan ZORUNLU değildir; ihtiyaç oldukça doldurulur.
            'custom_properties' => 'array',
        ];
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Permanent public URL. Use for public-disk media (e.g. product images).
     * Private media should use {@see temporaryUrl()} instead.
     */
    public function url(): ?string
    {
        if ($this->path === null || $this->path === '') {
            return null;
        }

        return Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Signed, expiring URL for private media (downloads, documents). Defaults
     * to a 5-minute window. Requires the disk to support temporary URLs
     * (the `local` disk has `serve => true`; S3 supports them natively).
     */
    public function temporaryUrl(?DateTimeInterface $expiresAt = null): ?string
    {
        if ($this->path === null || $this->path === '') {
            return null;
        }

        return Storage::disk($this->disk)->temporaryUrl(
            $this->path,
            $expiresAt ?? now()->addMinutes(5),
        );
    }

    public function fileExists(): bool
    {
        return Storage::disk($this->disk)->exists($this->path);
    }

    public function isPrivate(): bool
    {
        return $this->disk !== 'public';
    }
}
