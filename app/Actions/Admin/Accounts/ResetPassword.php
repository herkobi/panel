<?php

namespace  App\Actions\Admin\Accounts;

use App\Services\Admin\Settings\UserService;
use App\Events\Admin\Accounts\ResetPassword as Event;
use App\Traits\AuthUser;

class ResetPassword
{
    use AuthUser;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->initializeAuthUser();
    }

    public function execute(string $id, array $data): array
    {
        $result = $this->userService->resetPassword($id, $data);
        $user = $result['user'];
        $status = $result['status'];
        event(new Event($user, $this->user, $status)); // status'u da geçirin
        return ['user' => $user, 'status' => $status];
    }

}
