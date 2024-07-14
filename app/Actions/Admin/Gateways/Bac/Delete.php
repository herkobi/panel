<?php

namespace App\Actions\Admin\Gateways\Bac;

use App\Events\Admin\Gateways\Bac\Deleted;
use App\Services\Admin\Gateways\Bac\Service;

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
     * Belirtilen ID'ye sahip hesap bilgisini siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek vergi ID'si
     * @return void
     */
    public function execute($id)
    {
        $bac = $this->postService->getById($id);
        $this->postService->delete($id); // Hesap Bilgisini sil
        event(new Deleted($bac)); // Deleted olayını yayınla
        return $bac;
    }
}
