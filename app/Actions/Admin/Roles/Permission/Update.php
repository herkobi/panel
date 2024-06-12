<?php

namespace App\Actions\Admin\Roles\Permission;

use App\Events\Admin\Roles\Permission\Updated;
use App\Services\Admin\Roles\PermissionService as Service;

class Update
{
    protected $postService;

    /**
     * Update işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip izni günceller ve güncellenen izne ait olayı yayınlar.
     *
     * @param int $id Güncellenecek izin ID'si
     * @param array $data Yeni izin verileri
     * @return mixed Güncellenen izin
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
    }
}
