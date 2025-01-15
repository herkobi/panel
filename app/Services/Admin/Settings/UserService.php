<?php

namespace App\Services\Admin\Settings;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers(): Collection
    {
        return $this->repository->getAllUsers();
    }

    public function getAccounts(): Collection
    {
        return $this->repository->getAccounts();
    }

    public function getUserById(string $id, bool $withoutGlobalScope = false): User|Model
    {
        return $this->repository->getById($id, $withoutGlobalScope);
    }

    public function createUser(array $data): User
    {
        return $this->repository->createUser($data);
    }

    public function createAccount(array $data): User
    {
        return $this->repository->createAccount($data);
    }

    public function updateProfile(string $id, array $data): User
    {
        return $this->repository->updateProfile($id, $data);
    }

    public function deleteUser(string $id): void
    {
        $this->repository->delete($id);
    }

    public function statusUpdate(string $id, array $data): User
    {
        return $this->repository->updateStatus($id, $data);
    }

    public function changeEmail(string $id, array $data): User
    {
        return $this->repository->updateEmail($id, $data);
    }

    public function verifyEmail(string $id, array $data): User
    {
        return $this->repository->verifyEmail($id, $data);
    }

    public function checkEmail(string $id, array $data): User
    {
        return $this->repository->checkEmail($id, $data);
    }

    public function resetPassword(string $id, array $data): array
    {
        return $this->repository->resetPassword($id, $data);
    }

    public function getUserActivity(string $id)
    {
        return $this->repository->withActivities($id);
    }

    public function getUserAuthLogs(string $id)
    {
        return $this->repository->withAuthLogs($id);
    }
}
