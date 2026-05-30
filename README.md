# Herkobi

Admin **panel** and member **app** built on Laravel + Inertia + React. A single
codebase serves two areas — an admin panel (`/panel`) and a member application
(`/app`) — sharing one auth backend, one design system, and one set of
conventions.

## Tech stack

| Layer | Choice |
|---|---|
| Backend | Laravel 13 · PHP 8.3+ |
| Frontend | React 19 · TypeScript · Inertia.js v3 |
| Styling | Tailwind v4 · shadcn/ui · dark mode (`next-themes`) |
| Auth | Laravel Fortify (login, registration, email verification, password reset, 2FA) |
| Typed routes | Laravel Wayfinder |
| Authorization | Spatie laravel-permission (UI-driven, route-name = permission-name) |
| Audit | Spatie activitylog + yadahan authentication-log |
| Tests | Pest 4 (SQLite `:memory:`) |
| Tooling | Vite · Pint · ESLint · Prettier |

## Getting started

```bash
composer setup     # install deps, create .env, generate key, migrate, build assets
composer dev       # run server + queue listener + Vite together
```

Then visit the app. `/dashboard` redirects to `/panel` or `/app` based on the
signed-in user's type. The default seeded admin is `admin@admin.com` / `password`.

## Common commands

```bash
composer dev            # serve + queue + vite (development)
composer test           # config clear + Pint check + Pest
composer ci:check       # full CI parity: lint + format + types + tests

npm run lint            # ESLint --fix          npm run lint:check
npm run format          # Prettier write        npm run format:check
npm run types:check     # tsc --noEmit          npm run build

php artisan test --filter=Name
php artisan wayfinder:generate --with-form --no-interaction   # after route changes
```

## Project layout

```
app/
  Http/Controllers/{Panel,App}/   Requests, Resources mirror the same split
  Events/ Listeners/              event() → listener side effects (auto-discovered)
  Services/{Panel,App}/           business rules (controllers stay thin)
  Models/  Enums/  Concerns/      HasUuids, BelongsToAccount, HasStatus, HasMedia …
  Support/                        Branding, ActivitySubjectLabels
routes/
  panel.php  app.php  web.php     /panel (admin) · /app (member)
resources/
  js/pages/{panel,app}/           Inertia pages
  js/components/  js/hooks/        shared UI + hooks (ui/* is generated)
  js/types/                       central TypeScript types (barrel: @/types)
  views/                          Blade root + mail templates
lang/{tr,en}/                     Turkish primary, English parallel
```

## Conventions in one breath

- **Two areas, one contract.** Panel = admin, App = member; a single `auth`
  Inertia prop discriminated by `auth.type`. Use `usePanelAuth()` / `useAppAuth()`.
- **Account scoping.** Member data hangs off `account_id`; the `bind_account`
  middleware auto-scopes it. Never read `account_id` from request input.
- **Side effects via events.** Activity logs, notifications, and mail flow through
  `event() → listener`; never directly from a controller.
- **Authorization by convention.** Panel route name = permission name, enforced by
  the `route_permission` middleware; Super Admin bypasses everything; permissions
  are curated from the Yetkiler screen.
- **Branding from settings.** App name, logo, and favicon come from
  `App\Support\Branding`, with sensible `public/herkobi*.png` defaults.
- **Typed everything.** Wayfinder for routes, shared TS types in `@/types`.

For the full picture — architecture, the non-negotiable rules, and how to extend
the system — see **[AGENTS.md](AGENTS.md)**. To contribute, see
**[CONTRIBUTING.md](CONTRIBUTING.md)**.
