<?php

namespace App\Actions\Admin\Profile;

use App\Events\Admin\Profile\UpdatedPassword;
use App\Services\Admin\Profile\Service;

class UpdatePassword
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
     * Belirtilen ID'ye sahip kullanıcının şifresini günceller.
     *
     * @param int $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute($id, array $data)
    {
        $user = $this->postService->updatePassword($id, $data);
        event(new UpdatedPassword($user));
        return $user;
    }
}
