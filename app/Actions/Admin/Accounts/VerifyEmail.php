<?php

namespace App\Actions\Admin\Accounts;

use App\Models\User;
use App\Services\Admin\Settings\UserService;
use App\Events\Admin\Accounts\VerifyEmail as Event;
use App\Traits\AuthUser;

class VerifyEmail
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
        $user = $this->userService->verifyEmail($id, $data);
        event(new Event($user, $this->user));
        return $user;
    }
}
