<?php

namespace App\Actions\Admin\Settings\Settings\App;

use App\Events\Admin\Settings\Settings\AppUpdated;
use App\Services\Admin\Settings\Settings\AppService as Service;

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
     * Tüm uygulama ayarlarını günceller.
     *
     * @return mixed Uygulama ayarları listesi
     */
    public function execute(array $data, $type)
    {
        $app = $this->postService->updateData($data);
        event(new AppUpdated($app, $type));
        return $app;
    }
}
