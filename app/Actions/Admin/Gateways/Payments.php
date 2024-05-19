<?php

namespace App\Actions\Admin\Gateways;

use App\Services\Admin\Gateways\Service;

class Payments
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
     * Tüm ödeme sistemlerini getirir.
     *
     * @return mixed Ödeme Sistemleri Listesi
     */
    public function execute()
    {
        $payment = $this->postService->getPayments();
        return $payment;
    }
}
