# Herkobi

Admin **panel** and member **app** built on Laravel + Inertia + React. A single
codebase serves two areas — an admin panel (`/panel`) and a member application
(`/app`) — sharing one auth backend, one design system, and one set of
conventions. Herkobi is a **starter kit**: clone it, and the groundwork (auth,
authorization, settings, media, activity log, a module system) is already in
place so you can focus on what you actually want to build.

## Tech stack

| Layer | Choice |
|---|---|
| Backend | Laravel 13 · PHP 8.4+ |
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
  Support/Hooks/ Registry/ Modules/   module system (HookManager, Menu/PermissionRegistry, manifest)
  Console/Commands/               herkobi:install · herkobi:uninstall
routes/
  panel.php  app.php  web.php     /panel (admin) · /app (member)
packages/                         local module packages (path repository, optional)
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
- **Modular by design.** Composer packages add panel/app menu, routes, permissions,
  screens and mail through a **Hook + Registry** system — no core edits. See below.
- **Batteries included, not all wired up.** Some pieces (the full shadcn set,
  permission hooks, enum helpers, alternative layouts) ship ready-to-use but unmounted.
  That's deliberate scaffolding — reach for it, don't delete it.

## Modules

Herkobi has a built-in **module system**. A module is a composer package that
contributes to the panel/app without touching core code:

- **Hooks + Registries.** The core fires named extension points (`hooks()->do(...)`);
  a module's service provider attaches callbacks that write into typed registries —
  `MenuRegistry` (sidebar menu, permission-aware), `PermissionRegistry` (authz), and
  `{area}.routes.register` for routes (which inherit the area's full middleware stack).
- **Data-driven sidebar.** The menu is built per request and shared as the `navigation`
  Inertia prop; PHP sends string icon keys resolved to Lucide icons on the client.
- **Manifest-driven lifecycle.** Each module ships a `module.json` (identity, `requires`,
  a `from → to` publish map, lifecycle flags). Install and remove with:

```bash
composer require herkobi/todo      # backend works immediately (auto-discovery)
php artisan herkobi:install todo   # publish screens/mail + migrate + seed permissions
npm run build                      # compile the published front-end

php artisan herkobi:uninstall todo # reverse (before composer remove); --purge-data to drop tables
composer remove herkobi/todo
```

Front-end files are published into the host tree and import the host's shadcn/ui
components via `@`, so modules inherit the design system automatically.

For the full picture — architecture, the non-negotiable rules, the module system
internals, and how to extend the system — see **[AGENTS.md](AGENTS.md)**. To
contribute, see **[CONTRIBUTING.md](CONTRIBUTING.md)**.
