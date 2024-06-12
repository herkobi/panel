<?php

namespace App\Actions\Admin\Settings\Location\State;

use App\Services\Admin\Settings\Location\StateService as Service;

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
     * Belirtilen ID'ye sahip eyalet/şehri getirir.
     *
     * @param int $id Getirilecek eyalet/şehir ID'si
     * @return mixed Getirilen eyalet/şehir
     */
    public function execute($id)
    {
        $state = $this->postService->getById($id);
        return $state;
    }
}
