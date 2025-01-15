<?php

namespace App\Repositories;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Models\Authlog;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthLogsRepository extends BaseRepository
{
    protected $model = User::class;

    public function userAuthLogs(string $id): LengthAwarePaginator
    {
        return Authlog::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }

    public function usersAuthLogs(): LengthAwarePaginator
    {
        return Authlog::with('user')
            ->whereHas('user', function ($query) {
                $query->where('type', UserType::USER)
                    ->whereNotIn('status', [AccountStatus::DELETED]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }

    public function adminsAuthLogs(): LengthAwarePaginator
    {
        return Authlog::with('user')
            ->whereHas('user', function ($query) {
                $query->where('type', UserType::ADMIN)
                    ->whereNotIn('status', [AccountStatus::DELETED]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }
}
