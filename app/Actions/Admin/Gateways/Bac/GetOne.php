<?php

namespace App\Actions\Admin\Gateways\Bac;

use App\Services\Admin\Gateways\Bac\Service;

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
     * Belirtilen ID'ye sahip hesap bilgisini getirir.
     *
     * @param int $id Getirilecek hesap bilgisi ID'si
     * @return mixed Getirilen hesap bilgisi
     */
    public function execute($id)
    {
        $bac = $this->postService->getById($id);
        return $bac;
    }
}
