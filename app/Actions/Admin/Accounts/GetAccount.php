<?php

namespace App\Actions\Admin\Accounts;

use App\Services\Admin\Accounts\Service;

class GetAccount
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
     * Belirtilen ID'ye sahip kullanıcıyı getirir.
     *
     * @param int $id Getirilecek kullanıcı ID'si
     * @return mixed Getirilen kullanıcı
     */
    public function execute($id)
    {
        $account = $this->postService->getAccount($id);
        return $account;
    }
}
