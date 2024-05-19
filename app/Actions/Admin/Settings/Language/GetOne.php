<?php

namespace App\Actions\Admin\Settings\Language;

use App\Services\Admin\Settings\Language\Service;

class GetOne
{
    protected $postService;

    /**
     * GetOne işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip dili getirir.
     *
     * @param int $id Getirilecek dilin ID'si
     * @return mixed Getirilen dli
     */
    public function execute($id)
    {
        $language = $this->postService->getById($id);
        return $language;
    }
}
