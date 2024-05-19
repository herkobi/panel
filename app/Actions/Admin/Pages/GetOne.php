<?php

namespace App\Actions\Admin\Pages;

use App\Services\Admin\Page\Service;

class GetOne
{
    protected $postService;

    /**
     * GetOne işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip sayfayı getirir.
     *
     * @param int $id Getirilecek sayfa ID'si
     * @return mixed Getirilen sayfa
     */
    public function execute($id)
    {
        $page = $this->postService->getById($id);
        return $page;
    }
}
