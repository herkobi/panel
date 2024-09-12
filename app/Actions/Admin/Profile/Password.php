<?php

namespace App\Actions\Admin\Profile;

use App\Events\Admin\Profile\Password as Event;
use App\Services\Admin\Profile\ProfileService as Service;

class Password
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
     * @param string $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute(string $id, array $data)
    {
        $user = $this->postService->updatePassword($id, $data);
        event(new Event($user));
        return $user;
    }
}
