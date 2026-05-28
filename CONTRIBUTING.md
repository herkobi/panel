# Contributing

Thanks for considering a contribution to **Herkobi Panel**. This file covers the day-to-day basics; the deeper architectural notes live in [CLAUDE.md](CLAUDE.md).

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
composer dev   # Laravel + queue + Vite, concurrently
```

## Before opening a PR

Run the full CI parity check locally — same command CI runs:

```bash
composer ci:check
```

This executes, in order:

1. `npm run lint:check` — ESLint (no fixes)
2. `npm run format:check` — Prettier (no fixes)
3. `npm run types:check` — `tsc --noEmit`
4. `composer test` — Pint check + Pest suite

Fixers:

```bash
composer lint   # Pint --fix
npm run lint    # ESLint --fix
npm run format  # Prettier --write
```

After adding/modifying routes, regenerate Wayfinder typed actions/routes:

```bash
php artisan wayfinder:generate --with-form --no-interaction
```

## Architectural conventions (please respect)

These are the rules the codebase is built on; PRs that break them won't be merged.

- **Dual area separation:** `/panel` (admin) and `/app` (member) are mirrored, never mixed. New controllers, requests, resources, services, events, listeners, frontend pages live under `Panel/*` or `App/*`.
- **Event-driven side effects:** activity log, notifications, mail — all flow through `event() → listener`. Controllers stay thin, services hold business rules.
- **Notification standard:** `Send{X}` listener → `$notifiable->notify(new {X}Notification(...))`. The notification implements `ShouldQueue` and orchestrates both in-app (`database` channel) and queued mail (`toMail()` returning a Mailable). Don't dispatch a Job for routine mail.
- **Account ownership:** member-scoped models `use App\Concerns\BelongsToAccount`. Never accept `account_id` from request input; always create via `$account->relation()->create(...)` so Eloquent + the trait fill it.
- **Authorization:** every named panel route is auto-protected by `route_permission` middleware (convention: route name = permission name). Super Admin bypasses via `Gate::before`. New routes are curated in **Yetkiler → Rotalardan Keşfet**.
- **Shared concerns:** `HasStatus`, `HasSortOrder`, `HasMedia`, `LogsActivity`, `BelongsToAccount` — use them instead of duplicating scopes / casts / activity-log chains.
- **PHP file headers:** every file starts with `declare(strict_types=1);`.
- **UUIDs everywhere:** every model uses `HasUuids`.

## Writing tests

- Use Pest feature tests under `tests/Feature/`.
- Always `use RefreshDatabase` for DB-touching tests.
- For panel access, `User::factory()->admin()->create()` auto-assigns `Super Admin` (test ergonomics — Gate::before then bypasses everything). For middleware/permission-specific tests, instantiate via `User::factory()->state(['user_type' => UserType::Admin])->create()` so no role is attached.

## Localization

Turkish (`tr`) is primary; English (`en`) is parallel. Keep both `lang/tr/*.php` and `lang/en/*.php` in sync.

## Reporting issues

Please include:

- Laravel / PHP / Node versions
- Steps to reproduce
- Expected vs. actual behavior
- Output of `composer ci:check` if relevant

## Code of conduct

Be respectful, focus on the code, assume good intent. That's it.
