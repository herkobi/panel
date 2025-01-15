<?php

namespace App\Actions\Admin\Tools\Country;

use App\Models\Country;
use App\Services\Admin\Tools\CountryService;
use App\Events\Admin\Tools\Country\Create as Event;
use App\Traits\AuthUser;

class Create
{
    use AuthUser;

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        $this->initializeAuthUser();
    }

    public function execute(array $data): Country
    {
        $country = $this->countryService->createCountry($data);
        event(new Event($country, $this->user));
        return $country;
    }
}
