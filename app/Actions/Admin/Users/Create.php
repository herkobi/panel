<?php

namespace App\Actions\Admin\Users;

use App\Events\Admin\Users\Created;
use App\Services\Admin\Users\Service;

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
     * Yeni bir kullanıcı oluşturur ve oluşturulan kullanıcıya ait olayı yayınlar.
     *
     * @param array $data Yeni kullanıcı verileri
     * @return mixed Oluşturulan kullanıcı
     */
    public function execute(array $data)
    {
        $user = $this->postService->create($data);
        event(new Created($user));
        return $user;
    }
}
