<?php

namespace App\Actions\Admin\Gateways;

use App\Services\Admin\Gateways\Service;

class Currency
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
     * Tüm kullanılabilir para birimlerini getirir.
     *
     * @return mixed Kullanılabilir Para Birimleri Listesi
     */
    public function execute()
    {
        $currency = $this->postService->getCurrencies();
        return $currency;
    }
}
