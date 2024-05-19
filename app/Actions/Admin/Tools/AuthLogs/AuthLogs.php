<?php

namespace App\Actions\Admin\Tools\AuthLogs;

use App\Services\Admin\Tools\AuthLogsService as Service;

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
     * Tüm hesaplara ait işlemleri getirir.
     *
     * @return mixed Hesaplara ait işlem listesi
     */
    public function execute($id)
    {
        $auth = $this->postService->authLogs($id);
        return $auth;
    }
}
