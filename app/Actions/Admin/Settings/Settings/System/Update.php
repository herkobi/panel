<?php

namespace App\Actions\Admin\Settings\Settings\System;

use App\Events\Admin\Settings\Settings\SystemUpdated;
use App\Services\Admin\Settings\Settings\SystemService as Service;

class Update
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
     * Tüm sistem ayarlarını günceller.
     *
     * @return mixed Sistem ayarlarını güncelleme
     */
    public function execute($request, $type)
    {
        $settings = $this->postService->updateData($request);
        event(new SystemUpdated($settings, $type));
        return $settings;
    }
}
