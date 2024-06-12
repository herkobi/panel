<?php

namespace App\Actions\Admin\Users\Detail;

use App\Events\Admin\Users\Detail\CheckedEmail;
use App\Services\Admin\Users\Detail as Service;

class CheckEmail
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
     * Belirtilen kullanıcının e-posta adresini onaylama.
     *
     * @return mixed E-posta adresi onayı
     */
    public function execute($id, array $data)
    {
        $mail = $this->postService->checkEmail($id, $data);
        event(new CheckedEmail($mail));
        return $mail;
    }
}
