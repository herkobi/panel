<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Events\Panel\Tools\Definitions\Country\CountryActivatedEvent;
use App\Events\Panel\Tools\Definitions\Country\CountryCreatedEvent;
use App\Events\Panel\Tools\Definitions\Country\CountryDeactivatedEvent;
use App\Events\Panel\Tools\Definitions\Country\CountryDeletedEvent;
use App\Events\Panel\Tools\Definitions\Country\CountryForceDeletedEvent;
use App\Events\Panel\Tools\Definitions\Country\CountryRestoredEvent;
use App\Events\Panel\Tools\Definitions\Country\CountryUpdatedEvent;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CountryService
{
    public function __construct(
        private readonly DefinitionGuard $guard,
    ) {}

    public function create(array $data, User $causer): Country
    {
        return DB::transaction(function () use ($data, $causer) {
            $country = Country::create($data);

            CountryCreatedEvent::dispatch($country, $causer);

            return $country;
        });
    }

    public function update(Country $country, array $data, User $causer): Country
    {
        return DB::transaction(function () use ($country, $data, $causer) {
            $country->update($data);

            CountryUpdatedEvent::dispatch($country, $causer);

            return $country;
        });
    }

    public function deactivate(Country $country, User $causer): void
    {
        DB::transaction(function () use ($country, $causer) {
            $this->guard->ensureNotDefault('default_country_id', $country->id, 'Ülke');

            $country->update(['status' => Status::Passive]);

            CountryDeactivatedEvent::dispatch($country, $causer);
        });
    }

    public function activate(Country $country, User $causer): void
    {
        DB::transaction(function () use ($country, $causer) {
            $country->update(['status' => Status::Active]);

            CountryActivatedEvent::dispatch($country, $causer);
        });
    }

    public function delete(Country $country, User $causer): void
    {
        DB::transaction(function () use ($country, $causer) {
            $this->guard->ensureNotDefault('default_country_id', $country->id, 'Ülke');
            $this->guard->ensureNoChildren($country, 'cities', 'Ülke');

            $country->delete();

            CountryDeletedEvent::dispatch($country, $causer);
        });
    }

    public function restore(Country $country, User $causer): void
    {
        DB::transaction(function () use ($country, $causer) {
            $country->restore();

            CountryRestoredEvent::dispatch($country, $causer);
        });
    }

    public function forceDelete(Country $country, User $causer): void
    {
        DB::transaction(function () use ($country, $causer) {
            $this->guard->ensureNotDefault('default_country_id', $country->id, 'Ülke');
            $this->guard->ensureNoChildren($country, 'cities', 'Ülke');

            $country->forceDelete();

            CountryForceDeletedEvent::dispatch($country, $causer);
        });
    }
}
