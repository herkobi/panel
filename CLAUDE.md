# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

A detailed agent guide already exists at [AGENTS.md](AGENTS.md) — read it for full context. This file highlights the essentials.

## Commands

```bash
# Dev (Laravel + queue + Vite concurrently)
composer dev

# PHP — Pint format / Pest tests
composer lint              # fix
composer lint:check        # check only
composer test              # config clear + lint check + pest
php artisan test --filter=TestName        # single test

# JS/TS
npm run lint               # ESLint --fix
npm run lint:check
npm run format             # Prettier
npm run types:check        # tsc --noEmit
npm run build              # Vite prod build

# Full CI parity
composer ci:check          # lint:check + format:check + types:check + test

# Regenerate typed routes after any route change
php artisan wayfinder:generate --with-form --no-interaction
```

**Windows PHP path:** `C:\Users\bulent\.config\herd\bin\php.bat` (use directly if `php` is not on PATH).

**Tests** run on SQLite `:memory:` with `array` cache/session and `sync` queue. Use `RefreshDatabase` for feature tests touching the DB.

## Architecture

**Stack:** Laravel 13 (PHP 8.3+) · React 19 + TypeScript · Inertia.js v3 · Tailwind v4 · shadcn/ui · Pest 4. Auth via Fortify (login, 2FA/TOTP, email verification, password reset). Routes generated for the frontend via **Wayfinder** — never hardcode URLs.

**Dual area separation (Panel vs. App):** the entire codebase is split into two parallel user areas:

- `routes/panel.php` (prefix `/panel`, middleware `auth, verified, user_type:admin, active_user, write_access`) — admin users
- `routes/app.php` (prefix `/app`, middleware `auth, verified, user_type:member, active_user, write_access`) — member users
- `/dashboard` redirects by `user_type`; suppliers/inactive users are logged out.

This split is mirrored everywhere: `app/Http/Controllers/Panel/*` vs `App/*`, `Requests/Panel/*` vs `App/*`, `Resources/Panel/*` vs `App/*`, `Events/Panel|App|Auth/*`, `Listeners/Panel|App|Auth/*`, `Services/Panel/*`, `resources/js/pages/panel/*` vs `app/*`, layouts `panel/` vs `app/`.

**Inertia shared auth contract** — there is exactly ONE shared prop `auth`, discriminated by `auth.type: 'app' | 'panel'`. Types in [resources/js/types/auth.ts](resources/js/types/auth.ts). In React components NEVER read `usePage().props.auth` directly — use `useAppAuth()` in app-area code and `usePanelAuth()` in panel-area code. Never mix `AppUser` and `PanelUser`. Never introduce a second shared prop like `appAuth`/`panelAuth`.

**Event-driven side effects (hard rule).** Controllers stay thin; services hold business rules. Any side effect (activity log, notification, email, queued job) MUST flow through an `event() → listener` chain — never directly from a controller/service. Today: 23 events, 24 listeners, 3 notifications, 0 jobs, 0 mailables, 0 policies (authorization is middleware-based).

**Dependency direction (upper may depend on lower; never reverse):**
`Enum → Migration → Model → Service → Event → Listener → Notification → Job → Request → Controller → Resource → Page/UI → Middleware → Seeder → Permission`

**Data model:** every model uses `HasUuids` — primary and foreign keys are UUID strings. `User` uses soft deletes (admins cannot hard-delete). Enums live in `app/Enums/` (`Status`, `UserStatus`, `UserType`). Use PHP 8.3 attributes on models: `#[Fillable([...])]`, `#[Hidden([...])]`, `#[Scope]`. Every PHP file starts with `declare(strict_types=1);`.

**Custom middleware:** `EnsureActiveUser` (`active_user`), `EnsureUserType` (`user_type:admin|member`), `EnsureWriteAccess` (`write_access`), `HandleAppearance`, `HandleInertiaRequests` (shares the `auth` prop), `SetSecurityHeaders`.

**Frontend conventions:** TS strict mode, alias `@/* → ./resources/js/*`, React Compiler enabled (babel-plugin-react-compiler). shadcn/ui primitives in `resources/js/components/ui/` are generated — do not hand-edit and they are excluded from ESLint/Prettier. Use Inertia's `useForm` for forms and Wayfinder action/route functions for endpoints. Tailwind v4 (no `tailwind.config.js`); stylesheet entry `resources/css/app.css`. Dark mode via `next-themes`.

**Localization:** Turkish (`tr`) is actively maintained alongside English (`en`) in `lang/` — keep both in sync.

**Logging:** `spatie/laravel-activitylog` records key user actions; `yadahan/laravel-authentication-log` tracks every login. New DB-changing events should produce an activity log entry via a listener.

## Project rules worth knowing

- Run `php artisan wayfinder:generate` after adding/modifying routes.
- New email work → create a Job (queued) that dispatches a Mailable with views in `resources/views/mail/`. None exist yet.
- Authorization today is middleware-based; introduce Policies only when middleware no longer fits.
- See [komutlar.md](komutlar.md), [kurallar.md](kurallar.md), and [todo.md](todo.md) for project-specific Turkish notes on commands, rules, and pending work.
