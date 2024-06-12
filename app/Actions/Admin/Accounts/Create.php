<?php

namespace App\Actions\Admin\Accounts;

use App\Events\Admin\Accounts\Created;
use App\Services\Admin\Accounts\Service;

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
