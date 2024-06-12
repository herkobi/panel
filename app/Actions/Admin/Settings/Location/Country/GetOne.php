<?php

namespace App\Actions\Admin\Settings\Location\Country;

use App\Services\Admin\Settings\Location\CountryService as Service;

class GetOne
{
    protected $postService;

    /**
     * GetOne işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip ülkeyi getirir.
     *
     * @param int $id Getirilecek ülke ID'si
     * @return mixed Getirilen ülke
     */
    public function execute($id)
    {
        $country = $this->postService->getById($id);
        return $country;
    }
}
