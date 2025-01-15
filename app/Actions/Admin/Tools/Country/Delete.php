<?php

namespace App\Actions\Admin\Tools\Country;

use App\Services\Admin\Tools\CountryService;
use App\Events\Admin\Tools\Country\Delete as Event;
use App\Models\Country;
use App\Traits\AuthUser;

class Delete
{
    use AuthUser;

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        $this->initializeAuthUser();
    }

    public function execute(string $id): Country
    {
        $country = $this->countryService->getCountryById($id);
        $this->countryService->deleteCountry($id);
        event(new Event($country, $this->user));
        return $country;
    }
}
