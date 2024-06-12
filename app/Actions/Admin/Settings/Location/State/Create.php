<?php

namespace App\Actions\Admin\Settings\Location\State;

use App\Events\Admin\Settings\Location\State\Created;
use App\Services\Admin\Settings\Location\StateService as Service;

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
     * Yeni bir eyalet/şehir oluşturur ve oluşturulan eyalet/şehire ait olayı yayınlar.
     *
     * @param array $data Yeni eyalet/şehir verileri
     * @return mixed Oluşturulan eyalet/şehir
     */
    public function execute(array $data)
    {
        $state = $this->postService->create($data);
        event(new Created($state));
    }
}
