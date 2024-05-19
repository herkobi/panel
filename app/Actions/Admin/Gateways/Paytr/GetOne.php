<?php

namespace App\Actions\Admin\Gateways\Paytr;

use App\Services\Admin\Gateways\Paytr\Service;

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
     * Paytr ödeme yöntemine ait bilgileri getirir.
     *
     * @param int $id Paytr ID'si
     * @return mixed Paytr'ye ait billgiler
     */
    public function execute($id)
    {
        $paytr = $this->postService->getById($id);
        return $paytr;
    }
}
