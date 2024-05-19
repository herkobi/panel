<?php

namespace App\Actions\Admin\Settings\Tax;

use App\Services\Admin\Settings\Tax\Service;

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
     * Tüm vergileri ve ülkeleri getirir.
     *
     * @return mixed Vergi listesi
     */
    public function execute()
    {
        $tax = $this->postService->getAll();
        return $tax;
    }
}
