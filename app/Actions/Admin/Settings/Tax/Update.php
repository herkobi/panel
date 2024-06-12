<?php

namespace App\Actions\Admin\Settings\Tax;

use App\Events\Admin\Settings\Tax\Updated;
use App\Services\Admin\Settings\Tax\Service;

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
     * Belirtilen vergi ID'sine sahip vergiyi günceller ve güncellenen vergiye ait olayı yayınlar.
     *
     * @param int $id Güncellenecek vergi ID'si
     * @param array $data Yeni vergi verileri
     * @return mixed Güncellenen vergi
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
    }
}
