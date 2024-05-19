<?php

namespace App\Actions\Admin\Roles\Role;

use App\Events\Admin\Roles\Role\Created;
use App\Services\Admin\Roles\RoleService as Service;

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
     * Yeni izin oluşturur ve oluşturulan izne ait olayı yayınlar.
     *
     * @param array $data Yeni izin verileri
     * @return mixed Oluşturulan izin
     */
    public function execute(array $data)
    {
        $role = $this->postService->create($data);
        event(new Created($role));
    }
}
