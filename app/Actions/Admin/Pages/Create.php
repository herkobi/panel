<?php

namespace App\Actions\Admin\Pages;

use App\Events\Admin\Page\Created;
use App\Services\Admin\Page\Service;

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
     * Yeni sayfa oluşturur ve oluşturulan sayfaya ait olayı yayınlar.
     *
     * @param array $data Yeni sayfa verileri
     * @return mixed Oluşturulan sayfa
     */
    public function execute(array $data)
    {
        $page = $this->postService->create($data);
        event(new Created($page));
        return $page;
    }
}
