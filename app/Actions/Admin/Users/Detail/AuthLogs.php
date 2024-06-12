<?php

namespace App\Actions\Admin\Users\Detail;

use App\Services\Admin\Users\Detail as Service;

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
    public function execute($id)
    {
        $auth = $this->postService->authLogs($id);
        return $auth;
    }
}
