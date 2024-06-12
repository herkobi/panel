<?php

namespace App\Actions\Admin\Settings\Language;

use App\Services\Admin\Settings\Language\Service;

class GetAll
{
    protected $postService;

    /**
     * GetAll işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Tüm para birimlerini getirir.
     *
     * @return mixed Para Birimi Listesi
     */
    public function execute()
    {
        $language = $this->postService->getAll();
        return $language;
    }
}
