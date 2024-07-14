<?php

namespace App\Actions\Admin\Roles\Permission;

use App\Services\Admin\Roles\PermissionService as Service;

class UserPermissions
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
     * Tüm izinleri getirir.
     *
     * @return mixed İzin listesi
     */
    public function execute()
    {
        $permissions = $this->postService->userPermissions();
        return $permissions;
    }
}
