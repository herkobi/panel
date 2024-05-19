<?php

namespace App\Actions\Admin\Pages;

use App\Events\Admin\Page\Deleted;
use App\Services\Admin\Page\Service;

class Delete
{
    protected $postService;

    /**
     * Delete işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip sayfayı siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek sayfa ID'si
     * @return void
     */
    public function execute($id)
    {
        $page = $this->postService->getById($id);
        $this->postService->delete($id);
        event(new Deleted($page));
    }
}
