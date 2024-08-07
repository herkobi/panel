<?php

namespace App\Actions\Admin\Settings\Location\Country;

use App\Events\Admin\Settings\Location\Country\Updated;
use App\Services\Admin\Settings\Location\CountryService as Service;

class Update
{
    protected $postService;

    /**
     * Update işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen ID'ye sahip ülkeyi günceller ve güncellenen ülkeye ait olayı yayınlar.
     *
     * @param int $id Güncellenecek ülke ID'si
     * @param array $data Yeni ülke verileri
     * @return mixed Güncellenen ülke
     */
    public function execute($id, array $data)
    {
        $oldTitle = $this->postService->getById($id);
        $country = $this->postService->update($id, $data);
        $newTitle = $this->postService->getById($id);
        event(new Updated($oldTitle, $newTitle));
        return $country;
    }
}
