<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LanguageRepository extends BaseRepository
{
    protected $model = Language::class;

    public function getBySlug(string $slug)
    {
        return $this->model::where('slug', $slug)->firstOrFail();
    }

    public function getAllLanguages(): LengthAwarePaginator
    {
        return Language::orderBy('status', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(30);
    }

    public function getActiveLanguages(): Collection
    {
        return Language::where('status', Status::ACTIVE)
            ->orderBy('name', 'asc')
            ->get();
    }
}
