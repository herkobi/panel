<?php

namespace App\Actions\Admin\Accounts;

use App\Events\Admin\Accounts\CheckEmail as Event;
use App\Models\User;
use App\Services\Admin\Settings\UserService;
use App\Traits\AuthUser;

class CheckEmail
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
        $user = $this->userService->checkEmail($id, $data);
        event(new Event($user, $this->user));
        return $user;
    }
}
