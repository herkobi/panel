<?php

namespace App\Actions\Admin\Gateways\Bac;

use App\Events\Admin\Gateways\Bac\Created;
use App\Services\Admin\Gateways\Bac\Service;

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
     * Yeni banka hesap bilgisi oluşturur ve oluşturulan hesap bilgisine ait olayı yayınlar.
     *
     * @param array $data Yeni hesap bilgisi verileri
     * @return mixed Oluşturulan hesap bilgisi
     */
    public function execute(array $data)
    {
        $bac = $this->postService->create($data); // Hesap bilgisini oluştur
        event(new Created($bac));
    }
}
