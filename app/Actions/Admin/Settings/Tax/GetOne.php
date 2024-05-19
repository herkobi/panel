<?php

namespace App\Actions\Admin\Settings\Tax;

use App\Services\Admin\Settings\Tax\Service;

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
     * Belirtilen vergi ID'sine sahip vergiyi getirir.
     *
     * @param int $id Getirilecek vergi ID'si
     * @return mixed Getirilen vergi
     */
    public function execute($id)
    {
        $tax = $this->postService->getById($id);
        return $tax;
    }
}
