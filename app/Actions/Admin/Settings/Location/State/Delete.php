<?php

namespace App\Actions\Admin\Settings\Location\State;

use App\Events\Admin\Settings\Location\State\Deleted;
use App\Services\Admin\Settings\Location\StateService as Service;

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
     * Belirtilen ID'ye sahip eyalet/şehri siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek eyalet/şehir ID'si
     * @return void
     */
    public function execute($id)
    {
        $state = $this->postService->delete($id);
        event(new Deleted($state));
    }
}
