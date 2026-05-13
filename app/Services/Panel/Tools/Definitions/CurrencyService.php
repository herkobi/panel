<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyActivatedEvent;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyCreatedEvent;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyDeactivatedEvent;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyDeletedEvent;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyForceDeletedEvent;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyRestoredEvent;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyUpdatedEvent;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CurrencyService
{
    public function __construct(
        private readonly DefinitionGuard $guard,
    ) {}

    public function create(array $data, User $causer): Currency
    {
        return DB::transaction(function () use ($data, $causer) {
            $currency = Currency::create($data);

            CurrencyCreatedEvent::dispatch($currency, $causer);

            return $currency;
        });
    }

    public function update(Currency $currency, array $data, User $causer): Currency
    {
        return DB::transaction(function () use ($currency, $data, $causer) {
            $currency->update($data);

            CurrencyUpdatedEvent::dispatch($currency, $causer);

            return $currency;
        });
    }

    public function deactivate(Currency $currency, User $causer): void
    {
        DB::transaction(function () use ($currency, $causer) {
            $this->guard->ensureNotDefault('default_currency_id', $currency->id, 'Para birimi');

            $currency->update(['status' => Status::Passive]);

            CurrencyDeactivatedEvent::dispatch($currency, $causer);
        });
    }

    public function activate(Currency $currency, User $causer): void
    {
        DB::transaction(function () use ($currency, $causer) {
            $currency->update(['status' => Status::Active]);

            CurrencyActivatedEvent::dispatch($currency, $causer);
        });
    }

    public function delete(Currency $currency, User $causer): void
    {
        DB::transaction(function () use ($currency, $causer) {
            $this->guard->ensureNotDefault('default_currency_id', $currency->id, 'Para birimi');

            $currency->delete();

            CurrencyDeletedEvent::dispatch($currency, $causer);
        });
    }

    public function restore(Currency $currency, User $causer): void
    {
        DB::transaction(function () use ($currency, $causer) {
            $currency->restore();

            CurrencyRestoredEvent::dispatch($currency, $causer);
        });
    }

    public function forceDelete(Currency $currency, User $causer): void
    {
        DB::transaction(function () use ($currency, $causer) {
            $this->guard->ensureNotDefault('default_currency_id', $currency->id, 'Para birimi');

            $currency->forceDelete();

            CurrencyForceDeletedEvent::dispatch($currency, $causer);
        });
    }
}
