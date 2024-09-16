<?php

namespace App\Actions\Admin\Accounts;

use App\Services\Admin\Settings\UserService;
use App\Events\Admin\Accounts\Delete as Event;
use App\Models\User;
use App\Traits\AuthUser;
use Illuminate\Database\Eloquent\Model;

class Delete
{
    use AuthUser;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->initializeAuthUser();
    }

    public function execute(string $id): User
    {
        $user = $this->userService->getUserById($id);
        $this->userService->deleteUser($id);
        event(new Event($user, $this->user));
        return $user;
    }
}
