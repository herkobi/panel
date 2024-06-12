<?php

namespace App\Actions\Admin\Gateways;

use App\Services\Admin\Gateways\Service;

class CreditCards
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
     * Tüm kredi kartı ile ödeme bilgilerini getirir.
     *
     * @return mixed Kredi Kartı Ödeme Sistemlerinin Listesi
     */
    public function execute()
    {
        $cc = $this->postService->getCreditCards();
        return $cc;
    }
}
