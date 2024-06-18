<?php

namespace App\Actions\Admin\Gateways\Paytr;

use App\Events\Admin\Gateways\Paytr\Updated;
use App\Services\Admin\Gateways\Paytr\Service;

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
     * PayTr bilgilerini günceller ve güncellenen bilgiye ait olayı yayınlar.
     *
     * @param int $id PayTr ID'si
     * @param array $data Yeni Paytr Bilgileri
     * @return mixed Güncellenen içerik
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $paytr = $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
        return $paytr;
    }
}
