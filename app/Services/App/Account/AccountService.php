<?php

declare(strict_types=1);

namespace App\Services\App\Account;

use App\Events\App\Account\AccountUpdatedEvent;
use App\Models\Account;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AccountService
{
    /**
     * @return array{countries: Collection, cities: Collection, districts: Collection}
     */
    public function locationOptions(?string $countryId = null, ?string $cityId = null): array
    {
        $cities = $countryId !== null
            ? City::query()
                ->active()
                ->where('country_id', $countryId)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'country_id', 'name'])
            : new Collection;

        $districts = $cityId !== null
            ? District::query()
                ->active()
                ->where('city_id', $cityId)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'city_id', 'name'])
            : new Collection;

        return [
            'countries' => Country::query()
                ->active()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'name']),
            'cities' => $cities,
            'districts' => $districts,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateForUser(User $user, array $data): Account
    {
        $account = $user->account()->firstOrCreate();

        return $this->update($account, $user, $data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Account $account, User $updatedBy, array $data): Account
    {
        return DB::transaction(function () use ($account, $updatedBy, $data) {
            $attributes = [
                'title' => $data['title'] ?? null,
                'address' => $data['address'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'district_id' => $data['district_id'] ?? null,
                'city_id' => $data['city_id'] ?? null,
                'country_id' => $data['country_id'] ?? null,
            ];

            $account->update($attributes);

            AccountUpdatedEvent::dispatch($account->refresh(), $updatedBy);

            return $account;
        });
    }
}
