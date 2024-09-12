<?php

namespace App\Services\User\Profile;

use App\Models\User;
use App\Mail\NewUserEmail;
use App\Services\BaseService;
use App\Repositories\UserRepository;
use App\Repositories\AuthLogsRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

class ProfileService extends BaseService
{
    protected $repository;
    protected $authLogs;

    public function __construct(UserRepository $repository, AuthLogsRepository $authLogs)
    {
        $this->repository = $repository;
        $this->authLogs = $authLogs;
    }

    protected function prepareData(array $data, string $action): array
    {
        return $data;
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
        Mail::to($user->email)->send(new NewUserEmail($user, $data['password']));
        return $user;
    }

    public function authLogs(string $id): LengthAwarePaginator
    {
        return $this->authLogs->userAuthLogs($id);
    }
}
