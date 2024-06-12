<?php

namespace App\Actions\Admin\Tools\Cache;

use App\Events\Admin\Tools\Cache\View;
use App\Services\Admin\Tools\CacheService as Service;

class ClearView
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
     * @return mixed view:clear
     */
    public function execute()
    {
        $cache = $this->postService->clearView(); // Tüm vergileri getir
        event(new View($cache));
        return $cache;
    }
}
