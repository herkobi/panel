# AGENTS.md

Canonical engineering guide for **Herkobi** — read this before writing code. It
describes the architecture, the hard rules, and the day-to-day commands. Humans
and AI agents both work from this file; `CLAUDE.md` simply imports it.

## Stack

- **Backend:** Laravel 13 · PHP 8.3+ · Pest 4 (tests on SQLite `:memory:`).
- **Frontend:** React 19 · TypeScript (strict) · Inertia.js v3 · Tailwind v4 · shadcn/ui · Vite.
- **Auth:** Laravel Fortify (login, registration, email verification, password reset, 2FA/TOTP).
- **Typed routes:** Laravel **Wayfinder** generates route/action helpers into `resources/js/{routes,actions}`. Never hardcode URLs — regenerate after any route change.
- **Packages of note:** `spatie/laravel-permission`, `spatie/laravel-activitylog`, `yadahan/laravel-authentication-log`.

Every PHP file starts with `declare(strict_types=1);`. Every model uses `HasUuids`. `CarbonImmutable` everywhere.

## Commands

```bash
composer dev              # Laravel serve + queue listener + Vite, concurrently
composer setup            # First-time install (env, key, migrate, npm, build)

composer lint             # Pint (fix)
composer lint:check       # Pint (check only)
composer test             # config:clear + pint check + pest
php artisan test --filter=TestName

npm run lint              # ESLint --fix
npm run lint:check        # ESLint check
npm run format            # Prettier write
npm run format:check      # Prettier check
npm run types:check       # tsc --noEmit
npm run build             # Vite production build

composer ci:check         # lint:check + format:check + types:check + test (CI parity)

php artisan wayfinder:generate --with-form --no-interaction   # after any route change
```

Feature tests touching the DB use `RefreshDatabase`. Cache/session are `array`, queue is `sync` in tests.

## Architecture

### Dual area: Panel (admin) vs App (member)

Code is mirrored under `Panel/*` (admin) and `App/*` (member):

- `routes/panel.php` — prefix `/panel`, middleware `auth, verified, user_type:admin, active_user, write_access, route_permission`.
- `routes/app.php` — prefix `/app`, middleware `auth, verified, user_type:member, active_user, write_access, bind_account`.
- `/dashboard` redirects by `user_type`; suppliers / inactive users are logged out.

The split is mirrored in `app/Http/Controllers/{Panel,App}/*`, `Requests/{Panel,App}/*`, `Resources/{Panel,App}/*`, `Events/{Panel,App,Auth}/*`, `Listeners/{Panel,App,Auth}/*`, `Services/{Panel,App}/*`, `resources/js/pages/{panel,app}/*`, and layouts `panel/` vs `app/`.

### Inertia shared props

`HandleInertiaRequests::share()` exposes exactly these app-wide props:

- **`auth`** — the single auth contract, discriminated by `auth.type: 'app' | 'panel'`. In React **never** read `usePage().props.auth` directly: use `useAppAuth()` in app-area code and `usePanelAuth()` in panel-area code. Never mix `AppUser` and `PanelUser`. Never add a second auth prop. Types in [resources/js/types/auth.ts](resources/js/types/auth.ts).
- **`branding`** — app identity (see [Branding](#branding)). Read via `useBranding()`.
- **`flash`** — toast/flash payloads (see [Toasts & flash](#toasts--flash)).
- **`navigation`** — the sidebar menu tree, built per-request from `MenuRegistry` for the user's area, permission-filtered and `order`-sorted (see [Module system](#module-system-extensibility)).
- **`name`**, **`sidebarOpen`**.

### Account ownership & scoping

`Account` is the central owner of member data. Members (`user_type:member`) and member-scoped records hang off `account_id`; admins have `account_id = null` and are cross-account.

Member-scoped models `use App\Concerns\BelongsToAccount`, which adds the `account()` relation **plus** a conditional global scope and a `creating` hook. The `BindCurrentAccount` middleware (alias `bind_account`, applied **only** in the member `app` group) binds the authenticated user's Account; while bound, every `BelongsToAccount` query auto-filters by `account_id` and new records get `account_id` auto-filled. Outside that context (panel/admin, seeders, jobs) nothing is bound → no scope, so admins stay cross-account.

**`account_id` is NEVER taken from request input** — derive it from the bound account or set it via the relation (`$account->things()->create([...])`).

### Event-driven side effects (hard rule)

Controllers stay thin; services hold business rules. Any side effect (activity log, notification, email) MUST flow through an `event() → listener` chain — never directly from a controller/service. Listener **auto-discovery** is used (no `EventServiceProvider $listen` array). Roughly ~80 events, ~119 listeners, ~22 notifications, 12 mailables, 1 job, 0 policies.

### Notification / email standard

A `Send{X}` listener stays thin and calls `$notifiable->notify(new {X}Notification(...))` (building any URL/token first). The `{X}Notification implements ShouldQueue`, declares `via = ['mail','database']` (or a subset), returns the Mailable from `toMail()`, and writes the in-app row via `toArray()`. The Notification is the single orchestration point for both in-app and (queued) mail — do **not** dispatch a Job from a listener for routine mail. Reach for a Job only when the mail needs an independent lifecycle (custom queue/retry/batch); the only Job today is `Auth/DetectNewDeviceLogin`. Mail views live in `resources/views/mail/`.

### Authorization

Spatie laravel-permission, **UI-driven** (no permission config file, no Artisan sync). Three pieces work together:

- **`Gate::before` for Super Admin** ([AppServiceProvider](app/Providers/AppServiceProvider.php)) — any user with the `Super Admin` role passes every `can()` check. Super Admin is **not** assigned individual permissions and is **never offered in role selects** (assigned only via seeder/console).
- **`EnsureRoutePermission` middleware** (`route_permission`, panel group only) — convention: **route name = permission name**. Every named panel route is auto-protected by `$user->can($routeName)`. New panel routes are accessible only by Super Admin until the permission is curated. Exemptions: `panel.dashboard` and any `panel.profile.*` route (personal areas — profile/security/sessions/notifications are not permission-gated and are excluded from permission discovery).
- **Yetkiler UI** (`panel/settings/permissions`) — list/edit/delete permissions, add ad-hoc ones, or use **"Rotalardan Keşfet"** to bulk-import panel route names as permissions (auto-derived `group` / `label`). `permissions` carries two UI-metadata columns: `group` and `label` (nullable; null → "Diğer" + the permission name). The `RolePermissionSeeder` seeds only the two system roles (`Super Admin`, `Admin`); Admin starts empty and is curated via the UI. System roles cannot be deleted/renamed (`RoleService::SYSTEM_ROLES`).

Spatie's own `role` / `permission` / `role_or_permission` route-middleware aliases are registered (package default) but **unused** — this app gates by the `route_permission` convention, not per-route annotations. Introduce Policies only when route-level checks no longer fit (none today).

### Module system (extensibility)

Herkobi is a starter kit, so it ships a **module system** that lets composer packages add panel/app **menu, routes, permissions, screens and mail** without editing core. The mechanism is **Hook + Registry**, and it builds on Laravel's own primitives (package auto-discovery, provider lifecycle, typed registries) so dependency management, versioning, and namespace isolation come from the framework.

**Guiding principle:** `module.json` *declares* what to do (data); the artisan commands enforce *how* and the *safety*; real logic stays in typed PHP when needed (never inside strings/JSON).

#### Hook + Registry

- **Hooks** ([app/Support/Hooks/HookManager.php](app/Support/Hooks/HookManager.php), global `hooks()` helper) — the core fires named extension points; modules attach callbacks. `hooks()->do('panel.routes.register')` fires **inside** the panel middleware group, so module routes inherit the full stack (`route_permission`, etc.) and the `panel.` name prefix — they never hardcode the middleware. API: `action`/`do` for side effects, `filter`/`apply` for value transforms. Register callbacks in a provider's **`register()`** (before the core fires them); if a module depends on another module's registry contribution, write from `booted()` instead so ordering is moot.
- **Registries** ([MenuRegistry](app/Support/Registry/MenuRegistry.php), [PermissionRegistry](app/Support/Registry/PermissionRegistry.php)) — typed builders modules write into from the `{area}.menu.register` / `{area}.permissions.register` hooks. The **core's own menu** is registered the same way ([ModuleServiceProvider](app/Providers/ModuleServiceProvider.php)). The menu is permission-aware (`MenuRegistry` filters by `$user->can()`), `order`-sorted, rebuilt per request, and shared as the `navigation` Inertia prop. The sidebar ([components/{panel,app}/app-sidebar.tsx](resources/js/components/panel/app-sidebar.tsx)) renders it data-driven; PHP sends a **string icon key** resolved to a Lucide component via [navigation-icons.ts](resources/js/lib/navigation-icons.ts).

> In short: **hook = "when / where to contribute", registry = "what to add, typed".** The backbone is the registries' typed API, not arbitrary string logic; the hook only fires the contribution at the right moment.

#### Module = composer package

A module is an ordinary composer package, loaded by Laravel **auto-discovery** (`extra.laravel.providers` in its `composer.json`). There is **no PHP build step** — routes, controllers and registry contributions work the moment the package is required. **Build is front-end only** (Vite), after publishing.

```bash
composer require herkobi/todo      # backend works immediately (auto-discovery)
php artisan herkobi:install todo   # reads module.json: publish + migrate + seed permissions
npm run build                      # compile the published front-end (or npm run dev)

php artisan herkobi:uninstall todo # reverse — BEFORE composer remove; --purge-data drops tables
composer remove herkobi/todo
```

**Lifecycle order matters:** `herkobi:uninstall` must run **before** `composer remove`, because it reads what to reverse from `module.json`; remove the package first and the manifest is gone. Local development can skip publishing by adding a path repository (`packages/*`) to the root `composer.json`.

#### `module.json` manifest

Lives at the module root: identity + dependency gate + publish map + lifecycle flags. [ModuleManifest](app/Support/Modules/ModuleManifest.php) / [ModuleDiscovery](app/Support/Modules/ModuleDiscovery.php) are **read-only metadata** (for the install commands + a future Modules screen) — provider boot is left to Laravel.

```jsonc
{
  "key": "todo",
  "name": "Todo",
  "provider": "Herkobi\\Todo\\TodoServiceProvider",
  "areas": ["panel", "app"],
  "requires": { "php": "^8.3", "laravel": "^13.0", "herkobi": "^1.0" }, // soft gate + UI; real deps live in composer.json
  "publish": [                                                          // source (pkg-relative) → target (project-relative)
    { "from": "resources/js/pages/panel", "to": "resources/js/pages/panel/todo" },
    { "from": "resources/views/mail",     "to": "resources/views/vendor/todo" }
  ],
  "migrate": true,            // run install migrations
  "permissions": "remove",    // uninstall behavior: "remove" | "keep"
  "purge_data": false,        // uninstall default: keep data unless --purge-data
  "enabled": true
}
```

The `publish` map is reversed on uninstall (DRY); a module that needs different behavior may declare separate `install` / `uninstall` blocks.

#### Routes, menu, permissions

- **Routes** — the core fires `hooks()->do('{area}.routes.register')` *inside* the middleware group; a module registers its routes there and inherits the stack + name prefix. Per the `route_permission` convention (route name = permission name) a module's panel routes are Super-Admin-only until their matching permission is curated.
- **Permissions** — modules register permissions in `PermissionRegistry` with a `source` (the module key, e.g. `$permissions->addMany('panel', [...], source: 'todo')`). They surface in **"Rotalardan Keşfet"** on `composer require` (no install needed); `herkobi:install` also seeds them by `forSource('todo')` **without assigning to any role** (role distribution stays an admin decision; Super Admin passes via `Gate::before`).
- **Menu** — same `MenuRegistry` as core; the `navigation` prop is **in addition** to the `auth` / `branding` / `flash` contract — never alter those.

#### Install / uninstall safety

- **install** verifies `requires`, runs **conflict detection** (a route/permission name colliding with an existing record warns), copies the `publish` map (`--force` to overwrite), migrates if `migrate: true`, seeds permissions, then prints the `npm run build` reminder.
- **uninstall** is a **safe default**: it deletes only publish targets that are **unmodified** (byte-identical to source) and reports edited ones instead of clobbering them; it does **not** touch tables/data unless `--purge-data` (migration rollback + the module's settings rows). Permissions follow `module.json`'s `"permissions"` flag (`remove` → confirm + report affected roles, then delete; `keep` → leave them). **Path safety:** both `from` (inside the package root) and `to` (inside the project root) are validated — `../` escapes are rejected.
- **PHP `Installer` escape hatch** — for logic `module.json` can't express (data migration, external cleanup) a module may ship an optional class with `installed()` / `uninstalling()`; the command calls it if present.

#### Front-end consistency

Modules carry no design system of their own: they import the core's components via the **`@` alias** (`@/components/ui/*`, layouts, hooks) and ship pages as `.tsx`, compiled by the host's Vite/TS/alias. Published pages land in the host's `pages/**` scan path, so `Inertia::render('panel/todo/index')` resolves with no extra config.

#### Deferred by design

The admin **"Modules"** screen (runtime enable/disable) and **user sidebar ordering** (drag-and-drop) are intentionally not built yet; `module.json` and the order-aware registry are ready data sources for them. When adding a *core* panel feature, prefer registering its menu entry in `ModuleServiceProvider` (so it stays permission-gated and consistent).

### Branding

[App\Support\Branding](app/Support/Branding.php) is the **single source** for app identity:

- `name()` / `slogan()` → `settings` table, falling back to `config('app.name')`.
- `logo()` / `logoDark()` / `favicon()` → uploaded image URL from `settings`, falling back to the public defaults `public/herkobi.png`, `public/herkobi-white.png`, `public/herkobi-ikon.png`.
- `toArray()` is shared on every Inertia request as the `branding` prop (consumed via `useBranding()`).

Usage: Blade root `<title>` + favicon link; the sidebar [BrandHeader](resources/js/components/brand-header.tsx) (favicon + app name); the auth layout (logo, light/dark); the mail header (logo). **Favicon is used only in the sidebar; everywhere else uses the normal logo.** Custom values are managed from **Genel Ayarlar** (`panel/settings/general`) via the [ImageUpload](resources/js/components/image-upload.tsx) component, whose `fallbackUrl` previews the branding default when nothing is uploaded.

### Shared model concerns (`app/Concerns/`)

- `HasStatus` — `Active`/`Passive` scopes + `isActive()` for models using the `Status` enum.
- `HasSortOrder` — `ordered()` scope + auto `sort_order` integer cast.
- `BelongsToAccount` — Account relation + conditional global scope + creating hook (see above).
- `HasMedia` — polymorphic `media()` relation, `mediaIn()` / `firstMediaIn()`, and a `mediaAccountCode()` hook routing per-owner storage.
- `LogsActivity` — thin helper used in `Log*` / `Send*` listeners to DRY `spatie/laravel-activitylog` writes.

### Media system

`app/Models/Media.php`, `app/Services/Support/MediaService.php`, `app/Concerns/HasMedia.php`. Polymorphic `media` table with `disk`, `path`, `original_name`, `mime_type`, `size`, `collection`, `sort_order`, and a free-form `custom_properties` JSON column. `MediaService::attach/detach/reorder` (transactional, auto sort_order). `Media::url()` for public files, `Media::temporaryUrl(?DateTimeInterface)` for signed private access (default 5 min). Folder layout: member-owned → `public/{account.code}` and `private/{account.code}`; admin/global → `public/media` and `private/media`.

### Settings & activity log

- **Settings** — `Setting` model (cached via `Setting::allCached()`), groups `general` / `branding` / `defaults`. Managed by `SettingsService` and the Genel Ayarlar screen.
- **Activity log** — `spatie/laravel-activitylog`. [ActivitySubjectLabels](app/Support/ActivitySubjectLabels.php) maps subject classes to Turkish labels. The activity screen (`panel/tools/activity`) localizes event names to Turkish and filters by **causer user type** (Yönetici/Üye) via `whereHasMorph`. Logins are tracked by `yadahan/laravel-authentication-log`.

## Frontend conventions

- TS strict; alias `@/* → ./resources/js/*`. React Compiler is enabled.
- **shadcn/ui primitives** in `resources/js/components/ui/` are generated — **do not hand-edit** (excluded from ESLint/Prettier). The one deliberate exception is the global `cursor-pointer` baked into [button.tsx](resources/js/components/ui/button.tsx).
- Use Inertia's `useForm` + Wayfinder action/route functions for endpoints. Tailwind v4 (no `tailwind.config.js`); entry `resources/css/app.css`. Dark mode via `next-themes`.

### TypeScript types

- **Shared, duplicated, or backend-reflecting types → `resources/js/types/`** (barrel: `@/types`). Page `Props` / `PageProps` and trivial one-off view-models stay **inline** in the page.
- Reuse `Option<TValue>` (`types/option.ts`) for `{ value, label }` shapes — don't redefine per page.
- Domain types live with their domain: `definitions.ts` (Currency/Tax/Country/City/District/Language + their `*Option` `Pick<>` views), `permission.ts`, `role.ts`, `session.ts`, `user-status.ts`, etc.

### Shared components & hooks

- [DataPagination](resources/js/components/data-pagination.tsx) — renders any Laravel paginator (reads `meta.*` or top-level `total/from/to/links`). Backend pairs it with `PaginatedResource::make($paginator, ResourceClass, $request)`.
- [ConfirmDelete](resources/js/components/confirm-delete.tsx) — AlertDialog-based delete confirmation (props: `action`, `title`, `description`, `confirmLabel`, `confirmIcon`). Every destructive action confirms first.
- [BrandHeader](resources/js/components/brand-header.tsx), [ImageUpload](resources/js/components/image-upload.tsx), [media-gallery](resources/js/components/media-gallery.tsx) (kept ready, not currently mounted).
- Hooks: `useAppAuth` / `usePanelAuth`, `useBranding`, `usePermissions`, `useActiveNavHref` (longest-prefix match for inner-sidebar active state), `useFlashToast`, `useCurrentUrl`.
- **Sidebar:** `nav-main` shows sub-menus as a flyout **dropdown** when collapsed to icon mode; there is no resize rail.
- **Buttons:** if a group of buttons uses icons, all of them do — keep icon usage consistent (submit→Save, filter→Search, cancel→X, delete→Trash2, etc.).

### Intentional scaffolding (ready, not all wired up)

Herkobi ships as a **starter kit**, so a number of components/hooks/helpers are present and complete but **not currently imported anywhere** — they exist so a consumer can reach for them immediately. **This is deliberate; do not treat it as dead code or delete it during cleanup.** Known unused-but-ready pieces:

- **shadcn/ui primitives** (`components/ui/*`) — the **full set** is installed; only a subset is mounted today. Keep them all.
- **Permission hooks** — [use-permissions.ts](resources/js/hooks/use-permissions.ts) exports `useCan` / `useHasRole` / `useIsSuperAdmin` for gating UI; ready even where not yet called.
- **Enum view-helpers** — `*_LABEL` / `*_OPTIONS` / `*_VALUES` in [types/status.ts](resources/js/types/status.ts), [types/user-status.ts](resources/js/types/user-status.ts), [types/user-type.ts](resources/js/types/user-type.ts) for building selects/badges off the PHP enums.
- **Alternative layouts** — `auth/auth-card-layout`, `auth/auth-split-layout`, `app/app-header-layout`, `panel/app-header-layout` are unused variants; the active choices are `auth-simple-layout` and `app-sidebar-layout` (app + panel). Swap one in via the wrapper in `layouts/{auth,app,panel}-layout.tsx`.
- **[media-gallery](resources/js/components/media-gallery.tsx)** — kept ready, not currently mounted (see above).

### Toasts & flash

Controllers flash `->with('toast', ['type' => 'success|info|warning|error', 'message' => __('...')])`. [use-flash-toast](resources/js/hooks/use-flash-toast.ts) renders it through **sonner** (top-center, `richColors`). Domain guards surface user-facing warnings by throwing a renderable exception — e.g. [DefinitionGuardException](app/Exceptions/DefinitionGuardException.php) returns a `warning` toast instead of a generic 422.

## Data & definitions

- Enums in `app/Enums/`: `Status`, `UserStatus`, `UserType`. PHP 8.3 model attributes: `#[Fillable([...])]`, `#[Hidden([...])]`, `#[Scope]`.
- **Tanımlamalar** (`panel/tools/definitions`): countries/cities/districts, currencies, languages, taxes. Records are created **passive by default**; status is toggled from the table via a dedicated `/status` endpoint (its own activity event), not from the create/edit form. Currency carries `thousands_separator` + `decimal_separator`; Tax carries `sort_order`. Default selections (country/currency/tax/language/timezone) are guarded by `DefinitionGuard` (a default cannot be deactivated/deleted, and a record with children cannot be deleted).

## Localization & strictness

- Turkish (`tr`) is primary, English (`en`) parallel — keep both in `lang/` synchronized.
- `Model::preventLazyLoading(! production)` catches N+1 in dev/test. `DB::prohibitDestructiveCommands(production)`.

## Rules worth re-stating

- Run `php artisan wayfinder:generate` after adding/modifying routes.
- New email/notification → `ShouldQueue` Notification whose `toMail()` returns a Mailable, triggered from a `Send{X}` listener via `notify()`. Don't wrap routine mail in a Job.
- Member-scoped data: `use BelongsToAccount`; never accept `account_id` from input; create via the Account relation.
- Authorization: every panel route is auto-protected by `route_permission` (route name = permission name); Super Admin bypasses via `Gate::before`; new permissions are curated from **Yetkiler → Rotalardan Keşfet**. Profile routes are exempt.
- Side effects only via `event() → listener` (auto-discovery); don't register listeners manually.
- Shared/duplicated TS types → `@/types`; page `Props` stay inline.
- Don't hand-edit `components/ui/*` (generated).
- Unused-but-ready scaffolding is deliberate (full shadcn set, permission hooks, enum helpers, alternative layouts, `media-gallery`) — don't delete it as "dead code". See [Intentional scaffolding](#intentional-scaffolding-ready-not-all-wired-up).
- Extensibility goes through the **module system** (Hook + Registry): contribute menu/permissions from a provider via the `{area}.menu.register` / `{area}.permissions.register` hooks and routes via `{area}.routes.register`; never hardcode the sidebar or hand-edit the `navigation` prop. See [Module system](#module-system-extensibility).
