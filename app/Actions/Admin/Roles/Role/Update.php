<?php

namespace App\Actions\Admin\Roles\Role;

use App\Events\Admin\Roles\Role\Updated;
use App\Services\Admin\Roles\RoleService as Service;

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
     * Belirtilen ID'ye sahip yetkiyi günceller ve güncellenen yetkiye ait olayı yayınlar.
     *
     * @param int $id Güncellenecek yetki ID'si
     * @param array $data Yeni yetki verileri
     * @return mixed Güncellenen yetki
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
    }
}
