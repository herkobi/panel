<?php

namespace App\Actions\Admin\Users\Detail;

use App\Events\Admin\Users\Detail\ChangedPassword;
use App\Services\Admin\Users\Detail as Service;

class ChangePassword
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
     * Belirtilen kullanıcının şifresini değiştirme.
     *
     * @return mixed Şifre değişikliği
     */
    public function execute($id, array $data)
    {
        $password = $this->postService->changePassword($id, $data);
        event(new ChangedPassword($password));
        return $password;
    }
}
