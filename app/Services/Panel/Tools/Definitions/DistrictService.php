<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Events\Panel\Tools\Definitions\District\DistrictActivatedEvent;
use App\Events\Panel\Tools\Definitions\District\DistrictCreatedEvent;
use App\Events\Panel\Tools\Definitions\District\DistrictDeactivatedEvent;
use App\Events\Panel\Tools\Definitions\District\DistrictDeletedEvent;
use App\Events\Panel\Tools\Definitions\District\DistrictForceDeletedEvent;
use App\Events\Panel\Tools\Definitions\District\DistrictRestoredEvent;
use App\Events\Panel\Tools\Definitions\District\DistrictUpdatedEvent;
use App\Models\District;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DistrictService
{
    public function create(array $data, User $causer): District
    {
        return DB::transaction(function () use ($data, $causer) {
            $district = District::create($data);

            DistrictCreatedEvent::dispatch($district, $causer);

            return $district;
        });
    }

    public function update(District $district, array $data, User $causer): District
    {
        return DB::transaction(function () use ($district, $data, $causer) {
            $district->update($data);

            DistrictUpdatedEvent::dispatch($district, $causer);

            return $district;
        });
    }

    public function deactivate(District $district, User $causer): void
    {
        DB::transaction(function () use ($district, $causer) {
            $district->update(['status' => Status::Passive]);

            DistrictDeactivatedEvent::dispatch($district, $causer);
        });
    }

    public function activate(District $district, User $causer): void
    {
        DB::transaction(function () use ($district, $causer) {
            $district->update(['status' => Status::Active]);

            DistrictActivatedEvent::dispatch($district, $causer);
        });
    }

    public function delete(District $district, User $causer): void
    {
        DB::transaction(function () use ($district, $causer) {
            $district->delete();

            DistrictDeletedEvent::dispatch($district, $causer);
        });
    }

    public function restore(District $district, User $causer): void
    {
        DB::transaction(function () use ($district, $causer) {
            $district->restore();

            DistrictRestoredEvent::dispatch($district, $causer);
        });
    }

    public function forceDelete(District $district, User $causer): void
    {
        DB::transaction(function () use ($district, $causer) {
            $district->forceDelete();

            DistrictForceDeletedEvent::dispatch($district, $causer);
        });
    }
}
