<?php

namespace App\Services\Admin\Accounts;

use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;

class AccountService
{
    protected $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getLastThirtyDaysActiveMembers(): Collection
    {
        return $this->repository->getLastThirtyDaysActiveMembers();
    }

    public function getUnverifiedActiveUsers(): Collection
    {
        return $this->repository->getUnverifiedActiveUsers();
    }

    public function getInactiveActiveUsers(): Collection
    {
        return $this->repository->getInactiveActiveUsers();
    }

    public function getDraftUsers(): Collection
    {
        return $this->repository->getDraftUsers();
    }

    public function getPassiveUsers(): Collection
    {
        return $this->repository->getPassiveUsers();
    }

    public function getDeletedUsers(): Collection
    {
        return $this->repository->getDeletedUsers();
    }
}
