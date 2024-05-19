<?php

namespace App\Actions\Admin\Accounts;

use App\Services\Admin\Accounts\Service;

class GetAccounts
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
     * Tüm sistem kullanıcılarını getirir.
     *
     * @return mixed Kullanıcı listesi
     */
    public function execute()
    {
        $accounts = $this->postService->getAccounts();
        return $accounts;
    }
}
