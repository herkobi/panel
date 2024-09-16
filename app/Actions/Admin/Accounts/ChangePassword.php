<?php

namespace  App\Actions\Admin\Accounts;

use App\Services\Admin\Settings\UserService;
use App\Events\Admin\Accounts\ChangePassword as Event;
use App\Models\User;
use App\Traits\AuthUser;

class ChangePassword
{
    use AuthUser;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->initializeAuthUser();
    }

    public function execute(string $id, array $data): User
    {
        $user = $this->userService->changePassword($id, $data);
        event(new Event($user, $this->user));
        return $user;
    }
}
