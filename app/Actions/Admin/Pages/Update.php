<?php

namespace App\Actions\Admin\Pages;

use App\Events\Admin\Page\Updated;
use App\Services\Admin\Page\Service;

class Update
{
    protected $postService;

    /**
     * Update işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip sayfayı günceller ve güncellenen sayfaya ait olayı yayınlar.
     *
     * @param int $id Güncellenecek sayfa ID'si
     * @param array $data Yeni sayfa verileri
     * @return mixed Güncellenen sayfa
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $page = $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
        return $page;
    }
}
