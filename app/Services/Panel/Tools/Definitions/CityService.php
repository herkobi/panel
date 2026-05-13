<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Events\Panel\Tools\Definitions\City\CityActivatedEvent;
use App\Events\Panel\Tools\Definitions\City\CityCreatedEvent;
use App\Events\Panel\Tools\Definitions\City\CityDeactivatedEvent;
use App\Events\Panel\Tools\Definitions\City\CityDeletedEvent;
use App\Events\Panel\Tools\Definitions\City\CityForceDeletedEvent;
use App\Events\Panel\Tools\Definitions\City\CityRestoredEvent;
use App\Events\Panel\Tools\Definitions\City\CityUpdatedEvent;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CityService
{
    public function __construct(
        private readonly DefinitionGuard $guard,
    ) {}

    public function create(array $data, User $causer): City
    {
        return DB::transaction(function () use ($data, $causer) {
            $city = City::create($data);

            CityCreatedEvent::dispatch($city, $causer);

            return $city;
        });
    }

    public function update(City $city, array $data, User $causer): City
    {
        return DB::transaction(function () use ($city, $data, $causer) {
            $city->update($data);

            CityUpdatedEvent::dispatch($city, $causer);

            return $city;
        });
    }

    public function deactivate(City $city, User $causer): void
    {
        DB::transaction(function () use ($city, $causer) {
            $city->update(['status' => Status::Passive]);

            CityDeactivatedEvent::dispatch($city, $causer);
        });
    }

    public function activate(City $city, User $causer): void
    {
        DB::transaction(function () use ($city, $causer) {
            $city->update(['status' => Status::Active]);

            CityActivatedEvent::dispatch($city, $causer);
        });
    }

    public function delete(City $city, User $causer): void
    {
        DB::transaction(function () use ($city, $causer) {
            $this->guard->ensureNoChildren($city, 'districts', 'İl');

            $city->delete();

            CityDeletedEvent::dispatch($city, $causer);
        });
    }

    public function restore(City $city, User $causer): void
    {
        DB::transaction(function () use ($city, $causer) {
            $city->restore();

            CityRestoredEvent::dispatch($city, $causer);
        });
    }

    public function forceDelete(City $city, User $causer): void
    {
        DB::transaction(function () use ($city, $causer) {
            $this->guard->ensureNoChildren($city, 'districts', 'İl');

            $city->forceDelete();

            CityForceDeletedEvent::dispatch($city, $causer);
        });
    }
}
