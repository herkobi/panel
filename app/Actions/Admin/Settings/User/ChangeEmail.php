<?php

namespace App\Actions\Admin\Settings\User;

use App\Models\User;
use App\Services\Admin\Settings\UserService;
use App\Events\Admin\Settings\User\ChangeEmail as Event;
use App\Traits\AuthUser;

class ChangeEmail
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
        $user = $this->userService->changeEmail($id, $data);
        event(new Event($user, $this->user, newEmail: $data['email']));
        return $user;
    }
}
