<?php

namespace App\Actions\Admin\Tools\Cache;

use App\Events\Admin\Tools\Cache\Optimize;
use App\Services\Admin\Tools\CacheService as Service;

class ClearOptimize
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
     * @return mixed optimize:clear
     */
    public function execute()
    {
        $cache = $this->postService->clearOptimize(); // Tüm vergileri getir
        event(new Optimize($cache));
        return $cache;
    }
}
