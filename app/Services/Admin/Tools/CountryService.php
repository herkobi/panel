<?php

namespace App\Services\Admin\Tools;

use App\Repositories\CountryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryService
{
    protected $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCountries(): LengthAwarePaginator
    {
        return $this->repository->getAllCountries();
    }

    public function getActiveCountries(): Collection
    {
        return $this->repository->getActiveCountries();
    }

    public function getCountryById(string $id, bool $withoutGlobalScope = false): Country
    {
        return $this->repository->getById($id, $withoutGlobalScope);
    }

    public function createCountry(array $data): Country
    {
        return $this->repository->create($data);
    }

    public function updateCountry(string $id, array $data): Country
    {
        return $this->repository->update($id, $data);
    }

    public function deleteCountry(string $id): void
    {
        $this->repository->delete($id);
    }
}
