<?php

namespace App\Actions\User\Profile;

use App\Events\User\Account\Profile\Profile as Event;
use App\Services\User\Profile\ProfileService as Service;
use App\Traits\AuthUser;

class Profile
{
    use AuthUser;

    protected $postService;

    /**
     * GetOne işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
        $this->initializeAuthUser();
    }

    /**
     * Belirtilen ID'ye sahip kullanıcının profil bilgilerini günceller.
     *
     * @param string $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute(string $id, array $data)
    {
        $oldData = $this->postService->withMeta($id);
        $this->postService->updateProfile($id, $data);
        $newData = $this->postService->withMeta($id);
        event(new Event($this->user, $oldData, $newData));
        return $newData;
    }
}
