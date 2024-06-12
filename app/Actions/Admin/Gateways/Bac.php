<?php

namespace App\Actions\Admin\Gateways;

use App\Services\Admin\Gateways\Service;

class Bac
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
     * Tüm eft/havale ile ödeme bilgilerini getirir.
     *
     * @return mixed Eft/Havale Banka Bilgileri Listesi
     */
    public function execute()
    {
        $bac = $this->postService->getBac();
        return $bac;
    }

}
