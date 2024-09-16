<?php

namespace App\Repositories;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AccountRepository extends BaseRepository
{
    protected $model = User::class;

/**
     * Son 30 gün içinde üye olan aktif normal kullanıcıların listesini döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLastThirtyDaysActiveMembers(): Collection
    {
        return $this->model::where('created_at', '>=', Carbon::now()->subDays(30))
            ->where('type', UserType::USER->value)
            ->where('status', AccountStatus::ACTIVE->value)
            ->get();
    }

    /**
     * E-posta adresini onaylamamış aktif normal kullanıcıların listesini döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnverifiedActiveUsers(): Collection
    {
        return $this->model::whereNull('email_verified_at')
            ->where('type', UserType::USER->value)
            ->where('status', AccountStatus::ACTIVE->value)
            ->get();
    }

    /**
     * Son oturumun üzerinden 30 gün geçmiş aktif normal kullanıcıların listesini döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInactiveActiveUsers(): Collection
    {
        return $this->model::where('last_login_at', '<=', Carbon::now()->subDays(30))
            ->where('type', UserType::USER->value)
            ->where('status', AccountStatus::ACTIVE->value)
            ->get();
    }

    /**
     * Taslak durumundaki normal kullanıcıların listesini döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDraftUsers(): Collection
    {
        return $this->model::where('type', UserType::USER)
            ->where('status', AccountStatus::DRAFT)
            ->get();
    }

    /**
     * Pasif durumundaki normal kullanıcıların listesini döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPassiveUsers(): Collection
    {
        return $this->model::where('type', UserType::USER)
            ->where('status', AccountStatus::PASSIVE)
            ->get();
    }

    /**
     * Silinmiş durumundaki normal kullanıcıların listesini döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDeletedUsers(): Collection
    {
        return $this->model::where('type', UserType::USER)
            ->where('status', AccountStatus::DELETED)
            ->get();
    }
}
