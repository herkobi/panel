<?php

namespace App\Actions\Admin\Profile;

use App\Services\Admin\Profile\Service;

class GetUser
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
        $user = $this->postService->getUser($id);
        return $user;
    }
}
