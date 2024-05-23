<?php

namespace App\Actions\Admin\Profile;

use App\Events\Admin\Profile\UpdatedEmail;
use App\Services\Admin\Profile\Service;

class UpdateEmail
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
     * Belirtilen ID'ye sahip kullanıcının e-posta adresini günceller.
     *
     * @param int $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute($id, array $data)
    {
        $user = $this->postService->updateEmail($id, $data);
        event(new UpdatedEmail($user));
        return $user;
    }
}
