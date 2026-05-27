<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')
            ->orderBy('sort_order')
            ->orderBy('created_at');
    }

    public function mediaIn(string $collection): Collection
    {
        return $this->media()->where('collection', $collection)->get();
    }

    public function firstMediaIn(string $collection): ?Media
    {
        return $this->media()->where('collection', $collection)->first();
    }

    /**
     * Base directory (relative to the disk root) where this owner's media is
     * stored: account-owned media lives under the Account `code`, everything
     * else (admin/global) under `media`. Override {@see mediaAccountCode()}
     * rather than this method to keep the resolution in one place.
     */
    public function mediaDirectory(): string
    {
        return $this->mediaAccountCode() ?? 'media';
    }

    /**
     * Account code for account-owned media owners; `null` routes to the
     * admin/global `media` folder. Account-scoped models override this
     * (e.g. `return $this->account->code;`); Account itself returns its own.
     */
    protected function mediaAccountCode(): ?string
    {
        return null;
    }
}
