# AGENTS.md

> Agent-specific context for the Laravel Panel project.

## Project Overview

This is a Laravel 13 + React 19 admin panel application built on the Laravel React Starter Kit. It uses Inertia.js for seamless SPA-like navigation. The application serves two distinct user types: Admins (panel routes) and Members (app routes).

The project follows an event-driven architecture with strict layer separation. All side effects (logging, notifications, emails) are handled through events and listeners, never directly in controllers or services.

## Technology Stack

### Backend

- **Laravel 13.7** (PHP ^8.3)
- **Laravel Fortify** — Authentication (login, registration, 2FA/TOTP, email verification, password reset)
- **Laravel Wayfinder** — Auto-generates typed route functions for the frontend
- **Spatie Laravel Activity Log** — User action auditing
- **Yadahan Laravel Authentication Log** — Login/session tracking
- **Pest PHP 4** — Testing framework

### Frontend

- **React 19** with TypeScript
- **Inertia.js v3**
- **Tailwind CSS v4**
- **shadcn/ui** (New York style, Neutral base color)
- **Radix UI primitives**
- **Lucide React** — Icons
- **Vite 8** — Build tool
- **babel-plugin-react-compiler** — React compiler enabled

### Database & Runtime

- **Default database**: MySQL (configurable to SQLite, MariaDB, PostgreSQL, SQL Server). Tests always run on SQLite in-memory.
- **UUID primary keys** (`HasUuids` trait on all models)
- **Soft deletes** enabled on User model
- **Queue connection**: `database`
- **Cache store**: `database`
- **Session driver**: `database`
- **Broadcast connection**: `log`
- **Mail driver**: `log` (local), configurable

## Project Structure

```
app/
  Actions/Fortify/          # Custom Fortify actions (CreateNewUser, ResetUserPassword)
  Enums/                    # Status, UserStatus, UserType
  Events/                   # Domain events (Panel, App, Auth namespaces)
  Http/
    Controllers/            # Panel/* and App/* namespaces
    Middleware/             # Custom middleware (see below)
    Requests/               # Form requests (Panel/* and App/*)
    Resources/              # API resources (Panel/* and App/*)
  Jobs/                     # Queueable jobs (1: Auth/DetectNewDeviceLogin — device detection, not mail)
  Listeners/                # Event listeners (Panel, App, Auth namespaces)
  Mail/                     # Mailables (rendered by notifications' toMail())
  Models/                   # Eloquent models (10 files)
  Notifications/            # ShouldQueue notifications (Auth, App/Panel Profile, Members, Settings/User)
  Services/                 # Business logic (Panel/* namespaces)
bootstrap/
config/                     # Standard Laravel config
database/
  factories/                # UserFactory
  migrations/               # 18 migrations (framework + app)
  seeders/                  # DatabaseSeeder
lang/
  en/                       # auth, pagination, passwords, validation
  tr/                       # auth (Turkish locale actively maintained)
resources/
  css/                      # app.css (Tailwind v4 entry)
  js/
    actions/                # Wayfinder-generated action functions
    components/
      ui/                   # shadcn/ui primitives (~50 components)
      app/                  # App-area shared components
      panel/                # Panel-area shared components
    hooks/                  # Custom React hooks (useAppAuth, usePanelAuth, etc.)
    layouts/                # Page layouts (auth, app, panel, nested)
    pages/                  # Inertia page components
    routes/                 # Wayfinder-generated route helpers
    types/                  # TypeScript definitions
  views/                    # Blade views (app.blade.php, mail templates)
routes/
  web.php                   # Public routes + dashboard redirect
  panel.php                 # Admin panel routes (prefix: /panel)
  app.php                   # Member app routes (prefix: /app)
  console.php               # Artisan commands
tests/
  Feature/                  # 11 feature tests
  Unit/                     # 1 unit test
```

## Architecture Decisions

### User Type System

Users have a `user_type` enum (`admin`, `member`, `supplier`). Routes are protected by middleware:

- `user_type:admin` — Panel routes
- `user_type:member` — App routes
- `active_user` — Ensures user status is Active
- `write_access` — Ensures user has write permissions

The dashboard route (`/dashboard`) redirects based on user type:

- Admins -> `/panel/dashboard`
- Members -> `/app/dashboard`
- Suppliers or inactive users -> Logout with error toast

### Route Organization

```
routes/
  web.php      - Public routes + dashboard redirect
  panel.php    - Admin panel routes (prefix: /panel)
  app.php      - Member app routes (prefix: /app)
```

All panel routes share middleware: `['auth', 'verified', 'user_type:admin', 'active_user', 'write_access']`

All app routes share middleware: `['auth', 'verified', 'user_type:member', 'active_user', 'write_access']`

### Controller Structure

- `App\Http\Controllers\Panel\*` — Admin functionality
- `App\Http\Controllers\App\*` — Member functionality
- Definitions (CRUD resources) live under `Panel\Tools\Definitions\`

### Frontend Page Structure

```
resources/js/pages/
  auth/              - Fortify auth pages (login, register, 2FA, etc.)
  panel/             - Admin pages
    dashboard.tsx
    profile/
    settings/
    tools/           - Activity log, cache, definitions (CRUD)
  app/               - Member pages (mirrors panel structure)
```

### Route Functions (Wayfinder)

Always use Wayfinder-generated functions instead of hardcoded URLs.

Run `php artisan wayfinder:generate` when adding/modifying routes.

### Dependency Control (Bağımlılık Kontrolü)

The following layer order defines the dependency direction within the application. Upper layers may depend on lower layers, but lower layers must never depend on upper layers.

`Enum → Migration → Model → Service → Event → Listener → Notification → Job → Request → Controller → Resource → Page/UI → Middleware → Seeder → Permission`

- **Enum** — Type definitions used by models and business logic.
- **Migration** — Database schema definitions.
- **Model** — Eloquent models; may reference enums but nothing above.
- **Service** — Business logic; may use models, enums, and events.
- **Event** — Domain events fired from services or models.
- **Listener** — Reacts to events; may queue jobs or send notifications.
- **Notification** — User-facing alerts triggered by listeners or services.
- **Job** — Queueable units of work dispatched by listeners or controllers.
- **Request** — Form requests validating incoming HTTP data.
- **Controller** — Handles HTTP requests; may use requests, services, resources, and jobs.
- **Resource** — API response transformers.
- **Page / UI** — React pages and components; consumes controllers via Inertia.
- **Middleware** — HTTP layer filters; run before controllers.
- **Seeder** — Database seeders; may use models, enums, and services.
- **Permission** — Authorization rules applied to routes or controllers.

### Event Driven Development (Olay Odaklı Geliştirme)

Uygulama olay odaklı mimariyi takip eder. İş mantığı ve yan etkiler şu şekilde ayrılır:

- **Event (Olay)** — Domain olayları; model veya servis katmanından `event()` yardımcısı ile tetiklenir.
- **Listener (Dinleyici)** — Olayları dinler ve yan etkileri yürütür (örn. bildirim gönderme, job kuyruğa ekleme, loglama).
- **Controller** — İnce tutulur; iş mantığını doğrudan içermez. İşlemleri servis veya event'lere devreder.
- **Service** — İş kurallarını içerir; gerekli durumlarda event fırlatır.

Kural: Yan etkiler (bildirim, e-posta, kuyruk işi) doğrudan controller veya servis içinde gerçekleştirilmez; mutlaka bir event → listener zinciri üzerinden yürütülür.

Currently, the application has (approximate, grows over time):
- **~74 Events** — definitions CRUD events, profile/settings/members/cache/auth events
- **~109 Listeners** — activity log listeners plus `Send{X}` notification listeners
- **1 Job** — `Auth/DetectNewDeviceLogin` (device detection); routine mail goes through notifications, not jobs
- **~22 Notifications** — all `ShouldQueue`; Auth, App/Panel Profile, Members, Settings/User. Each handles in-app (`database`) and/or mail (`toMail()` → Mailable)
- **12 Mailables** — rendered by the notifications' `toMail()`
- **0 Policies** — authorization is handled via middleware currently

## Coding Standards

### PHP

- `declare(strict_types=1);` at the top of every PHP file
- Use PHP 8.3 attributes for Eloquent models: `#[Fillable([...])]`, `#[Hidden([...])]`, `#[Scope]`
- Use return type hints everywhere
- Pest for all tests (not PHPUnit syntax)
- Format with Laravel Pint (`composer lint`)

### React / TypeScript

- Functional components with explicit return types where helpful
- Use Inertia's `useForm` hook for form handling
- Use generated Wayfinder types for route parameters
- shadcn/ui components are in `resources/js/components/ui/`
- Custom components go in `resources/js/components/`
- TypeScript strict mode enabled
- Base URL alias: `@/*` maps to `./resources/js/*`

### Tailwind CSS

- Tailwind v4 syntax (no `tailwind.config.js`)
- Use `prettier-plugin-tailwindcss` for class sorting
- Dark mode support via `next-themes` (`dark:` prefix)
- Stylesheet entry: `resources/css/app.css`

### Form Requests and Validation

- Use Form Request classes for validation (not inline)
- Turkish (`tr`) and English (`en`) localization supported

### Linting & Formatting Rules

**ESLint** (`eslint.config.js`):
- Extends `@eslint/js`, `typescript-eslint`, `react`, `react-hooks`, `@stylistic/eslint-plugin`, `eslint-plugin-import`, `prettier`
- Enforces `consistent-type-imports` with separate type imports
- Enforces `import/order` with alphabetical sorting
- Enforces `curly: all` (always use braces)
- Enforces `@stylistic/brace-style: 1tbs`
- Enforces padding lines around control statements
- Ignores: `vendor`, `node_modules`, `public`, `bootstrap/ssr`, generated Wayfinder files, shadcn UI components

**Prettier** (`.prettierrc`):
- `semi: true`, `singleQuote: true`, `printWidth: 80`, `tabWidth: 4` (2 for YAML)
- Plugin: `prettier-plugin-tailwindcss` with `tailwindStylesheet: resources/css/app.css`
- Ignores: `resources/js/components/ui/*`, `resources/views/mail/*`

## Key Features

### Authentication (Fortify)
- Email/password login with rate limiting
- Registration with email verification
- Two-factor authentication (TOTP)
- Password reset flow
- Profile: update info, change password, 2FA setup, sessions, notifications

### Panel Tools (Admin)
- Activity Log — View user activity stream
- Cache Management — Clear application caches by type
- Definitions — CRUD for: Languages, Currencies, Countries, Cities, Districts, Taxes

### Settings
- General settings edit/update
- User listing and detail view

## Development Commands

### Start Development
```bash
# Start dev server (Laravel + Queue + Vite)
composer dev
```

### PHP
```bash
# Lint PHP
composer lint          # Fix with Pint
composer lint:check    # Check only

# Tests
composer test          # Config clear + lint check + artisan test
php artisan test       # Run Pest tests directly
./vendor/bin/pest      # Run Pest directly
```

### JavaScript / TypeScript
```bash
# Lint JS/TS
npm run lint           # Fix with ESLint
npm run lint:check     # Check only

# Format
npm run format         # Fix with Prettier
npm run format:check   # Check only

# Type check
npm run types:check    # tsc --noEmit

# Build
npm run build          # Vite production build
npm run build:ssr      # Vite build with SSR
```

### Full CI Check
```bash
composer ci:check      # lint:check + format:check + types:check + test
```

### Maintenance
```bash
php artisan wayfinder:generate         # Regenerate typed routes
php artisan wayfinder:generate --with-form --no-interaction
php artisan optimize:clear
php artisan migrate:fresh --seed
composer audit
npm audit --omit=dev
```

### PHP Location (Windows)

PHP is available at: **C:\Users\bulent\.config\herd\bin\php.bat**

You can run artisan commands directly using this path if needed:
```powershell
C:\Users\bulent\.config\herd\bin\php.bat artisan migrate:fresh --seed
C:\Users\bulent\.config\herd\bin\php.bat artisan wayfinder:generate
C:\Users\bulent\.config\herd\bin\php.bat artisan optimize:clear
```

## Testing

- **Pest PHP 4** with Laravel plugin
- **Feature tests** in `tests/Feature/` (11 files)
- **Unit tests** in `tests/Unit/` (1 file)
- Tests run on **SQLite in-memory** (`DB_DATABASE=:memory:`)
- Cache/session use `array` driver in testing
- Queue uses `sync` driver in testing
- Pulse, Telescope, and Nightwatch are disabled in testing
- `RefreshDatabase` trait is used for feature tests that need database isolation

### CI/CD (GitHub Actions)

**`.github/workflows/tests.yml`**:
- Triggers on push/PR to `develop`, `main`, `master`, `workos`
- Matrix: PHP 8.3, 8.4, 8.5
- Steps: checkout -> setup PHP (with xdebug) -> setup Node 22 -> `npm install` -> `composer install` -> copy `.env.example` -> `php artisan key:generate` -> `npm run build` -> run `./vendor/bin/pest`

**`.github/workflows/lint.yml`**:
- Triggers on push/PR to `develop`, `main`, `master`, `workos`
- Runs on `ubuntu-latest` with PHP 8.4
- Steps: checkout -> install PHP & Node deps -> `composer lint` (Pint) -> `npm run format` (Prettier) -> `npm run lint` (ESLint)

## Security Considerations

### Authentication & Authorization
- Single `web` session guard using Eloquent `User` model
- Fortify handles all auth flows with rate limiting (`throttle:6,1` on password updates)
- Two-factor authentication requires confirmation and password confirmation
- Password reset tokens expire in 60 minutes
- Password confirmation timeout: 3 hours (`AUTH_PASSWORD_TIMEOUT`)
- Users cannot be permanently deleted (soft deletes only)

### Middleware Security Stack
- `EnsureActiveUser` — Blocks inactive users
- `EnsureUserType` — Enforces admin/member route separation
- `EnsureWriteAccess` — Enforces write permission checks
- `HandleAppearance` — Manages theme/appearance preferences
- `HandleInertiaRequests` — Shares auth data and flash messages with Inertia
- `SetSecurityHeaders` — Applies security headers to responses

### Data Integrity
- All models use UUID primary keys (`HasUuids`)
- Foreign keys are UUID strings
- Form requests handle all validation; no inline validation in controllers
- `declare(strict_types=1)` on all PHP files

## Inertia Auth Architecture

The application uses a dual auth architecture:

- App
- Panel

Both use the same Inertia shared prop key:

```ts
auth
```

but are discriminated using:

```ts
auth.type
```

Possible values:

- `'app'`
- `'panel'`

## Type Definitions

Auth types are defined in:

- `resources/js/types/auth.ts`

Structure:

```ts
export type AppAuth = {
    type: 'app';
    user: AppUser | null;
};

export type PanelAuth = {
    type: 'panel';
    user: PanelUser | null;
};

export type Auth = AppAuth | PanelAuth;
```

## Inertia Shared Props

`HandleInertiaRequests` middleware MUST always share auth data using:

```php
'auth' => [
    'type' => ...,
    'user' => $user,
],
```

Never rename:

- `auth`
- `auth.type`
- `auth.user`

## Frontend Usage Rules

DO NOT use:

```ts
const { auth } = usePage().props;
```

inside pages/components.

Use dedicated hooks instead.

### App Area

Use:

```ts
useAppAuth()
```

Example:

```ts
const { user } = useAppAuth();
```

### Panel Area

Use:

```ts
usePanelAuth()
```

Example:

```ts
const { user } = usePanelAuth();
```

## Strict Rules

- App components/pages/layouts must only use `useAppAuth()`
- Panel components/pages/layouts must only use `usePanelAuth()`
- Never mix AppUser and PanelUser types
- Never access auth data directly from `usePage().props`
- Never introduce separate shared props like:
  - `appAuth`
  - `panelAuth`
- Always keep a single shared prop:
  - `auth`

## Important Notes

1. **Never hardcode URLs** — Always use Wayfinder-generated route functions.
2. **UUIDs everywhere** — All models use `HasUuids`. Foreign keys are UUID strings.
3. **Soft deletes on User** — Admins cannot permanently delete users.
4. **Turkish localization** — The `tr` locale is actively maintained alongside `en`.
5. **Fortify views enabled** — Inertia handles the frontend, but Fortify view routes are active.
6. **Authentication log** — Every login is tracked via `yadahan/laravel-authentication-log`.
7. **Activity log** — Key actions are logged via `spatie/laravel-activitylog`.
8. **Event-driven side effects** — Every database change must trigger an activity log entry via a listener. For user-facing alerts/email, a `Send{X}` listener calls `$notifiable->notify(new {X}Notification(...))`; the `ShouldQueue` notification handles both the in-app record (`toArray()`/`database`) and the queued mail (`toMail()` → Mailable, views in `resources/views/mail/`). Do not dispatch a Job for routine mail.
9. **No policies exist yet** — Authorization is currently middleware-based.
10. **Jobs are the exception, not the rule** — Routine mail flows through notifications. Add a Job only for work needing an independent lifecycle (custom queue/retry/batch); today only `Auth/DetectNewDeviceLogin` exists.

## Goal

This architecture exists to provide:

- strict type safety
- App/Panel isolation
- predictable frontend auth structure
- scalable long-term maintainability
- clear separation of business logic and side effects through event-driven design
