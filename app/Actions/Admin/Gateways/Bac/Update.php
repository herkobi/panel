<?php

namespace App\Actions\Admin\Gateways\Bac;

use App\Events\Admin\Gateways\Bac\Updated;
use App\Services\Admin\Gateways\Bac\Service;

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
     * Belirtilen ID'ye sahip hesap bilgisini günceller ve güncellenen hesap bilgisine ait olayı yayınlar.
     *
     * @param int $id Güncellenecek hesap bilgisi ID'si
     * @param array $data Yeni hesap bilgisi verileri
     * @return mixed Güncellenen hesap bilgisi
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
    }
}
