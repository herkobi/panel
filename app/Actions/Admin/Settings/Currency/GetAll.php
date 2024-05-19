<?php

namespace App\Actions\Admin\Settings\Currency;

use App\Services\Admin\Settings\Currency\Service;

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
     * Tüm para birimlerini getirir.
     *
     * @return mixed Para Birimleri Listesi
     */
    public function execute()
    {
        $currency = $this->postService->getAll();
        return $currency;
    }
}
