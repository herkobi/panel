<?php

namespace App\Actions\Admin\Settings\Tax;

use App\Events\Admin\Settings\Tax\Created;
use App\Services\Admin\Settings\Tax\Service;

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
     * Yeni vergi oluşturur ve oluşturulan vergiye ait olayı yayınlar.
     *
     * @param array $data Yeni vergi verileri
     * @return mixed Oluşturulan vergi
     */
    public function execute(array $data)
    {
        $tax = $this->postService->create($data);
        event(new Created($tax));
        return $tax;
    }
}
