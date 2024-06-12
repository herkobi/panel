<?php

namespace App\Actions\Admin\Roles\Permission;

use App\Services\Admin\Roles\PermissionService as Service;

class GetOne
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
     * Belirtilen ID'ye sahip izni getirir.
     *
     * @param int $id Getirilecek izin ID'si
     * @return mixed Getirilen izin
     */
    public function execute($id)
    {
        $permission = $this->postService->getById($id);
        return $permission;
    }
}
