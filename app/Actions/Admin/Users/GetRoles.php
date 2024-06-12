<?php

namespace App\Actions\Admin\Users;

use App\Services\Admin\Users\Service;

class GetRoles
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
     * Tüm yetkileri getirir.
     *
     * @return mixed Yetki listesi
     */
    public function execute()
    {
        $roles = $this->postService->getRoles();
        return $roles;
    }
}
