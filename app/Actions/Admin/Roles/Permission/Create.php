<?php

namespace App\Actions\Admin\Roles\Permission;

use App\Events\Admin\Roles\Permission\Created;
use App\Services\Admin\Roles\PermissionService as Service;

class Create
{
    protected $postService;

    /**
     * Kaydetme işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Yeni izin oluşturur ve oluşturulan izine ait olayı yayınlar.
     *
     * @param array $data Yeni izin verileri
     * @return mixed Oluşturulan izin
     */
    public function execute(array $data)
    {
        $permission = $this->postService->create($data);
        event(new Created($permission));
        return $permission;
    }
}
