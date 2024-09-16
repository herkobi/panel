<?php

namespace App\Actions\Admin\Settings\User;

use App\Services\Admin\Settings\UserService;
use App\Events\Admin\Settings\User\Create as Event;
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
        $user = $this->userService->createUser($data);
        event(new Event($user, $this->user, $data['name']));
        return $user;
    }
}
