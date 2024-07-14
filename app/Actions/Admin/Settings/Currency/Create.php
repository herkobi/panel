<?php

namespace App\Actions\Admin\Settings\Currency;

use App\Events\Admin\Settings\Currency\Created;
use App\Services\Admin\Settings\Currency\Service;

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
     * Yeni para birimi ekler ve eklenen para birimine ait olayı yayınlar.
     *
     * @param array $data Yeni para birimi verileri
     * @return mixed Oluşturulan para birimi
     */
    public function execute(array $data)
    {
        $currency = $this->postService->create($data);
        event(new Created($currency));
        return $currency;
    }
}
