<?php

namespace App\Actions\Admin\Settings\Location\Country;

use App\Services\Admin\Settings\Location\CountryService as Service;

class GetAll
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
     * Tüm ülkeleri getirir.
     *
     * @return mixed Ülke Listesi
     */
    public function execute()
    {
        $country = $this->postService->getAll();
        return $country;
    }
}
