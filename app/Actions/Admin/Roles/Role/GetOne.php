<?php

namespace App\Actions\Admin\Roles\Role;

use App\Services\Admin\Roles\RoleService as Service;

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
     * Belirtilen ID'ye sahip yetkiyi getirir.
     *
     * @param int $id Getirilecek yetki ID'si
     * @return mixed Getirilen yetki
     */
    public function execute($id)
    {
        $role = $this->postService->getById($id);
        return $role;
    }
}
