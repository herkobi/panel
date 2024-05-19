<?php

namespace App\Actions\Admin\Settings\Location\State;

use App\Events\Admin\Settings\Location\State\Updated;
use App\Services\Admin\Settings\Location\StateService as Service;

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
     * Belirtilen ID'ye sahip eyalet/şehri günceller ve güncellenen eyalet/şehire ait olayı yayınlar.
     *
     * @param int $id Güncellenecek eyalet/şehir ID'si
     * @param array $data Yeni eyalet/şehir verileri
     * @return mixed Güncellenen eyalet/şehir
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
    }
}
