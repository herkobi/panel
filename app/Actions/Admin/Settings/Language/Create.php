<?php

namespace App\Actions\Admin\Settings\Language;

use App\Events\Admin\Settings\Language\Created;
use App\Services\Admin\Settings\Language\Service;

class Create
{
    protected $postService;

    /**
     * Kaydetme işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Yeni dil ekler ve oluşturulan dile ait olayı yayınlar.
     *
     * @param array $data Yeni dil verileri
     * @return mixed Oluşturulan dil
     */
    public function execute(array $data)
    {
        $language = $this->postService->create($data);
        event(new Created($language));
        return $language;
    }
}
