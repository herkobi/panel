<?php

namespace App\Actions\Admin\Users;

use App\Services\Admin\Users\Service;

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
     * Tüm sistem kullanıcılarını getirir.
     *
     * @return mixed Kullanıcı listesi
     */
    public function execute()
    {
        $users = $this->postService->getUsers();
        return $users;
    }
}
