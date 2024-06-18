<?php

namespace App\Actions\Admin\Settings\Currency;

use App\Events\Admin\Settings\Currency\Deleted;
use App\Services\Admin\Settings\Currency\Service;

class Delete
{
    protected $postService;

    /**
     * Delete işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip para birimini siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek para birimi ID'si
     * @return void
     */
    public function execute($id)
    {
        $currency = $this->postService->delete($id);
        event(new Deleted($currency));
        return $currency;
    }
}
