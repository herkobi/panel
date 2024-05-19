<?php

namespace App\Actions\Admin\Tools\Cache;

use App\Events\Admin\Tools\Cache\Config;
use App\Services\Admin\Tools\CacheService as Service;

class ClearConfig
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
     * Cache temizleme.
     *
     * @return mixed config:clear
     */
    public function execute()
    {
        $cache = $this->postService->clearConfig(); // Tüm vergileri getir
        event(new Config($cache));
        return $cache;
    }
}
