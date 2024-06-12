<?php

namespace App\Actions\Admin\Tools\AuthLogs;

use App\Services\Admin\Tools\AuthLogsService as Service;

class GetUser
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
     * Belirtilen ID'ye sahip kullanıcıyı/hesabı getirir.
     *
     * @param int $id Getirilecek kullanıcı/hesap ID'si
     * @return mixed Getirilen kullanıcı/hesap bilgisi
     */
    public function execute($id)
    {
        $user = $this->postService->getUser($id);
        return $user;
    }
}
