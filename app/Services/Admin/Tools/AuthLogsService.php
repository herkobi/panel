<?php

namespace App\Services\Admin\Tools;

use App\Repositories\AuthLogsRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthLogsService
{
    protected $repository;

    public function __construct(AuthLogsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function userAuthLogs(string $id): LengthAwarePaginator
    {
        return $this->repository->userAuthLogs($id);
    }

    public function usersAuthLogs(): LengthAwarePaginator
    {
        return $this->repository->usersAuthLogs();
    }

    public function adminsAuthLogs(): LengthAwarePaginator
    {
        return $this->repository->adminsAuthLogs();
    }

}
