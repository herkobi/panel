<?php

namespace App\Repositories;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Models\Activity;
use App\Models\User;
use App\Models\Authlog;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivitiesRepository extends BaseRepository
{
    protected $model = User::class;

    public function userActivity(string $id): LengthAwarePaginator
    {
        return Activity::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }

    public function usersActivities(): LengthAwarePaginator
    {
        return Activity::with('user')
            ->whereHas('user', function ($query) {
                $query->where('type', UserType::USER)
                    ->whereNotIn('status', [AccountStatus::DELETED]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }

    public function adminsActivities(): LengthAwarePaginator
    {
        return Activity::with('user')
            ->whereHas('user', function ($query) {
                $query->where('type', UserType::ADMIN)
                    ->whereNotIn('status', [AccountStatus::DELETED]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }

    public function passwordsActivities(): LengthAwarePaginator
    {
        return Activity::with('user')
            ->where('message', 'password')
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }
}
