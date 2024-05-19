<?php

namespace App\Actions\Admin\Users\Detail;

use App\Events\Admin\Users\Detail\ChangedEmail;
use App\Services\Admin\Users\Detail as Service;

class ChangeEmail
{
    protected $postService;

    /**
     * GetAll işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Belirtilen kullanıcının e-posta adresini değiştirme.
     *
     * @return mixed E-posta adresi değişikliği
     */
    public function execute($id, array $data)
    {
        $mail = $this->postService->changeEmail($id, $data);
        event(new ChangedEmail($mail));
        return $mail;
    }
}
