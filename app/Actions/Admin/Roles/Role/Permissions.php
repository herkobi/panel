<?php

namespace App\Actions\Admin\Roles\Role;

use App\Services\Admin\Roles\RoleService as Service;

class Permissions
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
        $roles = $this->postService->permissions();
        return $roles;
    }
}
