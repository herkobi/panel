<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Events\Panel\Tools\Definitions\Tax\TaxActivatedEvent;
use App\Events\Panel\Tools\Definitions\Tax\TaxCreatedEvent;
use App\Events\Panel\Tools\Definitions\Tax\TaxDeactivatedEvent;
use App\Events\Panel\Tools\Definitions\Tax\TaxDeletedEvent;
use App\Events\Panel\Tools\Definitions\Tax\TaxForceDeletedEvent;
use App\Events\Panel\Tools\Definitions\Tax\TaxRestoredEvent;
use App\Events\Panel\Tools\Definitions\Tax\TaxUpdatedEvent;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TaxService
{
    public function __construct(
        private readonly DefinitionGuard $guard,
    ) {}

    public function create(array $data, User $causer): Tax
    {
        return DB::transaction(function () use ($data, $causer) {
            $tax = Tax::create($data);

            TaxCreatedEvent::dispatch($tax, $causer);

            return $tax;
        });
    }

    public function update(Tax $tax, array $data, User $causer): Tax
    {
        return DB::transaction(function () use ($tax, $data, $causer) {
            $tax->update($data);

            TaxUpdatedEvent::dispatch($tax, $causer);

            return $tax;
        });
    }

    public function deactivate(Tax $tax, User $causer): void
    {
        DB::transaction(function () use ($tax, $causer) {
            $this->guard->ensureNotDefault('default_tax_id', $tax->id, 'Vergi oranı');

            $tax->update(['status' => Status::Passive]);

            TaxDeactivatedEvent::dispatch($tax, $causer);
        });
    }

    public function activate(Tax $tax, User $causer): void
    {
        DB::transaction(function () use ($tax, $causer) {
            $tax->update(['status' => Status::Active]);

            TaxActivatedEvent::dispatch($tax, $causer);
        });
    }

    public function delete(Tax $tax, User $causer): void
    {
        DB::transaction(function () use ($tax, $causer) {
            $this->guard->ensureNotDefault('default_tax_id', $tax->id, 'Vergi oranı');

            $tax->delete();

            TaxDeletedEvent::dispatch($tax, $causer);
        });
    }

    public function restore(Tax $tax, User $causer): void
    {
        DB::transaction(function () use ($tax, $causer) {
            $tax->restore();

            TaxRestoredEvent::dispatch($tax, $causer);
        });
    }

    public function forceDelete(Tax $tax, User $causer): void
    {
        DB::transaction(function () use ($tax, $causer) {
            $this->guard->ensureNotDefault('default_tax_id', $tax->id, 'Vergi oranı');

            $tax->forceDelete();

            TaxForceDeletedEvent::dispatch($tax, $causer);
        });
    }
}
