<?php

namespace App\Actions\Admin\Settings\Tax;

use App\Services\Admin\Settings\Tax\Service;

class Countries
{
    protected $postService;

    /**
     * Kayıtlı ülke listesini almak için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Kayıtlı ülke listesini getirir.
     *
     * @return mixed Sistem Ayarları Listesi
     */
    public function execute()
    {
        $countries = $this->postService->getCountries();
        return $countries;
    }
}
