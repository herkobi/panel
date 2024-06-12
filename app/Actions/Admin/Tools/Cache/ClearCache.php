<?php

namespace App\Actions\Admin\Tools\Cache;

use App\Events\Admin\Tools\Cache\Cache;
use App\Services\Admin\Tools\CacheService as Service;

class ClearCache
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
     * @return mixed cache:clear
     */
    public function execute()
    {
        $cache = $this->postService->clearCache();
        event(new Cache($cache));
        return $cache;
    }
}
