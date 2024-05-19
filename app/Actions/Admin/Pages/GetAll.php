<?php

namespace App\Actions\Admin\Pages;

use App\Services\Admin\Page\Service;

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
     * Tüm sayfaları getirir.
     *
     * @return mixed Sayfa listesi
     */
    public function execute()
    {
        $pages = $this->postService->getAll();
        return $pages;
    }
}
