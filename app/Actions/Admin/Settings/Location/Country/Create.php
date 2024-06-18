<?php

namespace App\Actions\Admin\Settings\Location\Country;

use App\Events\Admin\Settings\Location\Country\Created;
use App\Services\Admin\Settings\Location\CountryService as Service;

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
     * Yeni bir ülke oluşturur ve oluşturulan ülkeye ait olayı yayınlar.
     *
     * @param array $data Yeni ülke verileri
     * @return mixed Oluşturulan ülke
     */
    public function execute(array $data)
    {
        $country = $this->postService->create($data);
        event(new Created($country));
        return $country;
    }
}
