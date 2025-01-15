<?php

namespace App\Services\Admin\Tools;

use App\Repositories\ActivitiesRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivitiesService
{
    protected $repository;

    public function __construct(ActivitiesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function userActivity(string $id): LengthAwarePaginator
    {
        return $this->repository->userActivity($id);
    }

    public function usersActivities(): LengthAwarePaginator
    {
        return $this->repository->usersActivities();
    }

    public function adminsActivities(): LengthAwarePaginator
    {
        return $this->repository->adminsActivities();
    }

    public function passwordsActivities(): LengthAwarePaginator
    {
        return $this->repository->passwordsActivities();
    }

}
