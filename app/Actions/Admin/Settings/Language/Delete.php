<?php

namespace App\Actions\Admin\Settings\Language;

use App\Events\Admin\Settings\Language\Deleted;
use App\Services\Admin\Settings\Language\Service;

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
     * Belirtilen ID'ye sahip dili siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek dilin ID'si
     * @return void
     */
    public function execute($id)
    {
        $language = $this->postService->delete($id);
        event(new Deleted($language));
        return $language;
    }
}
