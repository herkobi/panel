<?php

namespace App\Actions\Admin\Tools\Country;

use App\Services\Admin\Tools\CountryService;
use App\Events\Admin\Tools\Country\Update as Event;
use App\Models\Country;
use App\Traits\AuthUser;

class Update
{
    use AuthUser;

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        $this->initializeAuthUser();
    }

    public function execute(string $id, array $data): Country
    {
        $oldCountry = $this->countryService->getCountryById($id);
        $country = $this->countryService->updateCountry($id, $data);
        $newCountry = $this->countryService->getCountryById($id);
        event(new Event($country, $this->user, $oldCountry, $newCountry));
        return $country;
    }
}
