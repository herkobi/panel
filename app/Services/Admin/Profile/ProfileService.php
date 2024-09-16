<?php

namespace App\Services\Admin\Profile;

use App\Models\User;
use App\Mail\NewAdminEmail;
use App\Repositories\UserRepository;
use App\Repositories\AuthLogsRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

class ProfileService
{
    protected $repository;
    protected $authLogs;

    public function __construct(UserRepository $repository, AuthLogsRepository $authLogs)
    {
        $this->repository = $repository;
        $this->authLogs = $authLogs;
    }

    public function getById(string $id)
    {
        return $this->repository->getById($id);
    }

    public function updateProfile(string $id, array $data): User
    {
        return $this->repository->updateProfile($id, $data);
    }

    public function updateEmail(string $id, array $data): ?User
    {
        $user = $this->repository->updateEmail($id, $data);
        if ($user) {
            $user->sendEmailVerificationNotification();
        }
        return $user;
    }

    public function updatePassword(string $id, array $data): User
    {
        $user = $this->repository->updatePassword($id, $data);
        Mail::to($user->email)->send(new NewAdminEmail($user, $data['password']));
        return $user;
    }

    public function authLogs(string $id): LengthAwarePaginator
    {
        return $this->authLogs->userAuthLogs($id);
    }
}
