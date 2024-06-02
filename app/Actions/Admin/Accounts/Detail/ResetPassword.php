<?php

namespace App\Actions\Admin\Accounts\Detail;

use App\Events\Admin\Accounts\Detail\ResetedPassword;
use App\Services\Admin\Accounts\Detail as Service;

class ResetPassword
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
        $result = $this->postService->resetPassword($id, $data);
        $status = $result['status'];
        $user = $result['user'];
        event(new ResetedPassword($user));
        return $status;
    }
}
