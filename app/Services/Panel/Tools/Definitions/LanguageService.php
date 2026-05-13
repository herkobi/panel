<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Events\Panel\Tools\Definitions\Language\LanguageActivatedEvent;
use App\Events\Panel\Tools\Definitions\Language\LanguageCreatedEvent;
use App\Events\Panel\Tools\Definitions\Language\LanguageDeactivatedEvent;
use App\Events\Panel\Tools\Definitions\Language\LanguageDeletedEvent;
use App\Events\Panel\Tools\Definitions\Language\LanguageForceDeletedEvent;
use App\Events\Panel\Tools\Definitions\Language\LanguageRestoredEvent;
use App\Events\Panel\Tools\Definitions\Language\LanguageUpdatedEvent;
use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LanguageService
{
    public function __construct(
        private readonly DefinitionGuard $guard,
    ) {}

    public function create(array $data, User $causer): Language
    {
        return DB::transaction(function () use ($data, $causer) {
            $language = Language::create($data);

            LanguageCreatedEvent::dispatch($language, $causer);

            return $language;
        });
    }

    public function update(Language $language, array $data, User $causer): Language
    {
        return DB::transaction(function () use ($language, $data, $causer) {
            $language->update($data);

            LanguageUpdatedEvent::dispatch($language, $causer);

            return $language;
        });
    }

    public function deactivate(Language $language, User $causer): void
    {
        DB::transaction(function () use ($language, $causer) {
            $this->guard->ensureNotDefault('default_language_code', $language->code, 'Dil');

            $language->update(['status' => Status::Passive]);

            LanguageDeactivatedEvent::dispatch($language, $causer);
        });
    }

    public function activate(Language $language, User $causer): void
    {
        DB::transaction(function () use ($language, $causer) {
            $language->update(['status' => Status::Active]);

            LanguageActivatedEvent::dispatch($language, $causer);
        });
    }

    public function delete(Language $language, User $causer): void
    {
        DB::transaction(function () use ($language, $causer) {
            $this->guard->ensureNotDefault('default_language_code', $language->code, 'Dil');

            $language->delete();

            LanguageDeletedEvent::dispatch($language, $causer);
        });
    }

    public function restore(Language $language, User $causer): void
    {
        DB::transaction(function () use ($language, $causer) {
            $language->restore();

            LanguageRestoredEvent::dispatch($language, $causer);
        });
    }

    public function forceDelete(Language $language, User $causer): void
    {
        DB::transaction(function () use ($language, $causer) {
            $this->guard->ensureNotDefault('default_language_code', $language->code, 'Dil');

            $language->forceDelete();

            LanguageForceDeletedEvent::dispatch($language, $causer);
        });
    }
}
