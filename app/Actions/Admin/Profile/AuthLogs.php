<?php

namespace App\Actions\Admin\Profile;

use App\Services\Admin\Profile\Service;

class AuthLogs
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
     * Kullanıcıya ait oturum kayıtlarını getirir.
     *
     * @return mixed Oturum kayıtları listesi
     */
    public function execute(int $userId)
    {
        $auth = $this->postService->authLogs($userId);
        return $auth;
    }
}
