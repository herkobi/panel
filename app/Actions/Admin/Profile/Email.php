<?php

namespace App\Actions\Admin\Profile;

use App\Events\Admin\Profile\Email as Event;
use App\Services\Admin\Profile\ProfileService as Service;

class Email
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
     * @param string $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute(string $id, array $data)
    {
        $user = $this->postService->updateEmail($id, $data);
        event(new Event($user));
        return $user;
    }
}
