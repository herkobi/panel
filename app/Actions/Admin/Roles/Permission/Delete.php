<?php

namespace App\Actions\Admin\Roles\Permission;

use App\Events\Admin\Roles\Permission\Deleted;
use App\Services\Admin\Roles\PermissionService as Service;

class Delete
{
    protected $postService;

    /**
     * Delete işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip izni siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek izin ID'si
     * @return void
     */
    public function execute($id)
    {
        $permission = $this->postService->delete($id);
        event(new Deleted($permission));
    }
}
