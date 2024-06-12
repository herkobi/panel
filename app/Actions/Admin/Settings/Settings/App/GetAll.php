<?php

namespace App\Actions\Admin\Settings\Settings\App;

use App\Services\Admin\Settings\Settings\AppService as Service;

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
     * Tüm uygulama ayarlarını getirir.
     *
     * @return mixed Uygulama ayarları listesi
     */
    public function execute()
    {
        $app = $this->postService->appData();
        return $app;
    }
}
