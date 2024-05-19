<?php

namespace App\Actions\Admin\Accounts\Detail;

use App\Events\Admin\Accounts\Detail\ChangedPassword;
use App\Services\Admin\Accounts\Detail as Service;

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
