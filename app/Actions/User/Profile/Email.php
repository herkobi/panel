<?php

namespace App\Actions\User\Profile;

use App\Events\User\Profile\Email as Event;
use App\Services\User\Profile\ProfileService as Service;
use App\Traits\AuthUser;

class Email
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
     * Belirtilen ID'ye sahip kullanıcının e-posta adresini günceller.
     *
     * @param string $id Getirilecek kullanıcı ID'si
     * @return mixed Güncellenecek veriler
     */
    public function execute(string $id, array $data)
    {
        $oldMail = $this->postService->getById($id);
        $this->postService->updateEmail($id, $data);
        $newMail = $this->postService->getById($id);
        event(new Event($this->user, $oldMail, $newMail));
        return $newMail;
    }
}
