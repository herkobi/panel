<?php

namespace App\Actions\User\Profile;

use App\Events\User\Profile\Profile as Event;
use App\Services\User\Profile\ProfileService as Service;

class Profile
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
     * @param string $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute(string $id, array $data)
    {
        $user = $this->postService->updateProfile($id, $data);
        event(new Event($user));
        return $user;
    }
}
