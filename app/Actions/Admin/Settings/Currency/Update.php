<?php

namespace App\Actions\Admin\Settings\Currency;

use App\Events\Admin\Settings\Currency\Updated;
use App\Services\Admin\Settings\Currency\Service;

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
     * Belirtilen ID'ye sahip para birimini günceller ve güncellenen para birimine ait olayı yayınlar.
     *
     * @param int $id Güncellenecek para birimi ID'si
     * @param array $data Yeni para birimi verileri
     * @return mixed Güncellenen para birimi
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
    }
}
