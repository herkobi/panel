<?php

namespace App\Actions\Admin\Settings\Currency;

use App\Services\Admin\Settings\Currency\Service;

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
     * Belirtilen ID'ye sahip para birimini getirir.
     *
     * @param int $id Getirilecek para birimi ID'si
     * @return mixed Getirilen para birimi
     */
    public function execute($id)
    {
        $currency = $this->postService->getById($id);
        return $currency;
    }
}
