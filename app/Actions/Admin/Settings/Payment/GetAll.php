<?php

namespace App\Actions\Admin\Settings\Payment;

use App\Services\Admin\Settings\Payment\Service;

class GetAll
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
     * Tüm ödeme yöntemlerini getirir.
     *
     * @return mixed Vergi listesi
     */
    public function execute()
    {
        $payments = $this->postService->getAll();
        return $payments;
    }
}
