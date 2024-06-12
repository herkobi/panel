<?php

namespace App\Actions\Admin\Settings\Tax;

use App\Events\Admin\Settings\Tax\Deleted;
use App\Services\Admin\Settings\Tax\Service;

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
     * Belirtilen ID'ye sahip vergiyi siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek vergi ID'si
     * @return void
     */
    public function execute($id)
    {
        $tax = $this->postService->delete($id);
        event(new Deleted($tax));
    }
}
