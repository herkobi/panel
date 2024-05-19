<?php

namespace App\Actions\Admin\Settings\Location\State;

use App\Services\Admin\Settings\Location\StateService as Service;

class GetCountryStates
{
    protected $postService;

    /**
     * GetAll işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ülkeye ait tüm eyalet/şehirleri getirir.
     *
     * @return mixed Ülkeye ait eyalet/şehir listesi
     */
    public function execute(int $countryId)
    {
        $countries = $this->postService->getStatesByCountry($countryId);
        return $countries;
    }

    /**
     * Tüm ülkeleri getirir.
     *
     * @return mixed Ülkeler listesi
     */
    public function getCountry(int $countryId)
    {
        $country = $this->postService->getCountry($countryId);
        return $country;
    }

}
