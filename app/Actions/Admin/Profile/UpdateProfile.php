<?php

namespace App\Actions\Admin\Profile;

use App\Events\Admin\Profile\UpdatedProfile;
use App\Services\Admin\Profile\Service;

class UpdateProfile
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
     * Belirtilen ID'ye sahip kullanıcının profil bilgilerini günceller.
     *
     * @param int $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute($id, array $data)
    {
        $user = $this->postService->updateProfile($id, $data);
        event(new UpdatedProfile($user));
        return $user;
    }
}
