<?php

namespace App\Actions\Admin\Accounts\Detail;

use App\Events\Admin\Accounts\Detail\VerifiedEmail;
use App\Services\Admin\Accounts\Detail as Service;

class VerifyEmail
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
     * Belirtilen kullanıcının e-posta adresine onay linki gönderme.
     *
     * @return mixed E-posta gönderimi
     */
    public function execute($id, array $data)
    {
        $mail = $this->postService->verifyEmail($id, $data);
        event(new VerifiedEmail($mail));
        return $mail;
    }
}
