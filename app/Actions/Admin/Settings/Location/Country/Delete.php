<?php

namespace App\Actions\Admin\Settings\Location\Country;

use App\Events\Admin\Settings\Location\Country\Deleted;
use App\Services\Admin\Settings\Location\CountryService as Service;

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
     * Belirtilen ID'ye sahip ülkeyi siler, olayı yayınlar ve loglar.
     *
     * @param int $id Silinecek ülke ID'si
     * @return void
     */
    public function execute($id)
    {
        $country = $this->postService->delete($id);
        event(new Deleted($country));
    }
}
