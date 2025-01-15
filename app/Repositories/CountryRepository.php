<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CountryRepository extends BaseRepository
{
    protected $model = Country::class;

    public function getBySlug(string $slug)
    {
        return $this->model::where('slug', $slug)->firstOrFail();
    }

    public function getAllCountries(): LengthAwarePaginator
    {
        return Country::orderBy('status', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(30);
    }

    public function getActiveCountries(): Collection
    {
        return Country::where('status', Status::ACTIVE)->get();
    }
}
