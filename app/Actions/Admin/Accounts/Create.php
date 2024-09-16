<?php

namespace App\Actions\Admin\Accounts;

use App\Services\Admin\Settings\UserService;
use App\Events\Admin\Accounts\Create as Event;
use App\Models\User;
use App\Traits\AuthUser;

class Create
{
    use AuthUser;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->initializeAuthUser();
    }

    public function execute(array $data): User
    {
        $user = $this->userService->createAccount($data);
        event(new Event($user, $this->user, $data['name']));
        return $user;
    }
}
