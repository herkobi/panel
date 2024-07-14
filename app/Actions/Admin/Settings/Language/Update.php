<?php

namespace App\Actions\Admin\Settings\Language;

use App\Events\Admin\Settings\Language\Updated;
use App\Services\Admin\Settings\Language\Service;

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
     * Belirtilen ID'ye sahip dili günceller ve güncellenen dile ait olayı yayınlar.
     *
     * @param int $id Güncellenecek dil ID'si
     * @param array $data Yeni dil verileri
     * @return mixed Güncellenen dil
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $language = $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
        return $language;
    }
}
