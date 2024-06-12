<?php

namespace App\Actions\Admin\Settings\Settings\System;

use App\Services\Admin\Settings\Settings\SystemService as Service;

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
     * Tüm sistem ayarlarını getirir.
     *
     * @return mixed Sistem Ayarları Listesi
     */
    public function execute()
    {
        $settings = $this->postService->settingsData();
        return $settings;
    }
}
