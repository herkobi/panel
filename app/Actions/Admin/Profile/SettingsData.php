<?php

namespace App\Actions\Admin\Profile;

use App\Services\Admin\Profile\Service;

class SettingsData
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
