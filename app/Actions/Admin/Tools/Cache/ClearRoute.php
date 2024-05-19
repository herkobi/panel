<?php

namespace App\Actions\Admin\Tools\Cache;

use App\Events\Admin\Tools\Cache\Route;
use App\Services\Admin\Tools\CacheService as Service;

class ClearRoute
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
     * @return mixed route:clear
     */
    public function execute()
    {
        $cache = $this->postService->clearRoute(); // Tüm vergileri getir
        event(new Route($cache));
        return $cache;
    }
}
