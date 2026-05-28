# Herkobi Panel

> A free, open-source Laravel boilerplate that ships with a clean dual-area (admin + member) architecture, an account-scoped multi-tenancy primitive, role/permission management, polymorphic media, and a complete auth + profile stack — so you can focus on your product, not on the plumbing.

**MIT licensed. Use it for your CMS, your SaaS, your micro-ERP, whatever you need.**

---

## What you get out of the box

- **Two cleanly separated areas**
    - `/panel` for admins (`user_type:admin`)
    - `/app` for members (`user_type:member`)
    - Mirrored folders, mirrored code, zero leakage between them.

- **Authentication (Fortify)** — login, registration, email verification, password reset & confirmation, **2FA / TOTP** (QR + recovery codes), new-device login detection with a notification + activity-log entry.

- **Member & admin user management** — create, status changes, email verification, email change (signed confirmation link), role assignment.

- **Account ownership layer** — every member belongs to an `Account` (created automatically on email verification with a unique `code`). Member-scoped data hangs off `account_id`, not `user_id`. A `BelongsToAccount` trait + `BindCurrentAccount` middleware auto-scope queries and auto-fill foreign keys **only in the member area**. Admins remain cross-account. The schema already supports multiple members per account — going multi-user-per-account later is a non-migration change.

- **Role + permission (Spatie), UI-driven** — every named panel route is auto-protected via a single `route_permission` middleware (convention: route name = permission name). `Gate::before` grants `Super Admin` everything. A dedicated **Yetkiler** admin UI lets you list/edit/delete permissions, add ad-hoc ones, or bulk-discover new panel routes and import them as permissions with auto-derived group + label. Roles UI groups the permission checkboxes by the same metadata.

- **Profile package (both areas)** — profile info & email update (throttled), password change, 2FA management, active sessions list + remote revocation, in-app notification center, light/dark/system appearance.

- **Settings (admin)** — app identity (name, slogan, brand assets: logo / logo dark / favicon with immediate Upload / Delete buttons), default country/currency/tax/language/timezone.

- **Definitions** — Country, City, District, Language, Currency, Tax CRUD with soft-delete + restore + force-delete.

- **Tools** — activity log viewer, type-based cache clear.

- **Polymorphic media system** — `Media` model + `HasMedia` trait + `MediaService` (attach / detach / reorder) on top of a clean `FileService` (`public` & `local` disks). Member-owned media lives under `public/{account.code}` and `private/{account.code}`; admin/global under `public/media` and `private/media`. `Media::url()` for public, `Media::temporaryUrl()` for signed private access. Reusable `ImageUpload` and `MediaGallery` React components.

- **Event-driven architecture (hard rule)** — every side effect (activity log, notification, email) flows through `event → listener`. Controllers stay thin. Listener auto-discovery handles wiring.

- **Notification standard** — `ShouldQueue` Notifications combine in-app (`database` channel) + queued mail (`toMail()` returning a Mailable). Listeners only call `$notifiable->notify(...)`; no Job wrapping for routine mail.

- **Activity & login audit** — Spatie activitylog for actions, Yadahan authentication-log for every login.

- **Multi-language** — Turkish (`tr`, default) and English (`en`) kept in lockstep in `lang/`.

- **Modern frontend** — React 19 + TypeScript (strict) + Inertia.js v3 + Tailwind v4 + shadcn/ui. **Wayfinder** for end-to-end typed route / action functions — never hardcode URLs.

- **DX defaults** — `Model::preventLazyLoading` in non-production (catches N+1 early), `DB::prohibitDestructiveCommands` in production, `CarbonImmutable` everywhere, strict Pest test suite, full CI parity via `composer ci:check`.

---

## Tech stack

**Backend**

- Laravel 13 (PHP 8.3+)
- Laravel Fortify · Wayfinder
- Spatie Laravel Permission · Spatie Activity Log
- Yadahan Authentication Log
- Pest 4

**Frontend**

- React 19 + TypeScript (strict)
- Inertia.js v3
- Tailwind CSS v4 (no config file, `resources/css/app.css` entry)
- shadcn/ui + Base UI primitives
- Lucide React icons · `next-themes`
- Vite 8

**Database / runtime**

- MySQL by default (SQLite / MariaDB / Postgres compatible)
- **UUID** primary keys everywhere (`HasUuids`)
- `User` uses **soft deletes**

---

## Quick start

```bash
# 1. Clone & install
git clone <your-fork-or-this-repo>
cd panel
composer install
npm install
cp .env.example .env
php artisan key:generate

# 2. Configure DB credentials in .env, then:
php artisan migrate --seed

# 3. Start dev (Laravel + queue worker + Vite concurrently)
composer dev
```

**Seeded accounts (change before production):**

| Email | Password | Role |
| --- | --- | --- |
| `admin@admin.com` | `password` | Super Admin |
| `panel@admin.com` | `password` | Admin |
| `user@user.com` | `password` | Member (with an Account + Address) |

---

## Project structure (highlights)

```
app/
  Concerns/             # Shared model traits (HasStatus, HasSortOrder, BelongsToAccount, HasMedia, LogsActivity)
  Enums/                # Status, UserStatus, UserType
  Events/Panel|App|Auth # Domain events (event-driven side effects)
  Listeners/            # Log* (activity) + Send* (notify) + Provision* (account)
  Http/
    Controllers/Panel|App
    Requests/Panel|App
    Resources/Panel|App
    Middleware/         # custom auth/area/scope middleware
  Mail/                 # Mailables rendered by notifications
  Models/               # all use HasUuids; User uses soft deletes
  Notifications/        # all ShouldQueue, via=mail+database
  Services/Panel|App    # business logic
  Services/Account      # AccountProvisioner (idempotent account creation)
  Services/Support      # FileService, MediaService
resources/
  js/
    components/         # ui/ (shadcn, generated), image-upload, media-gallery, …
    pages/panel/        # admin pages
    pages/app/          # member pages
    types/              # TS types (barrel via index.ts)
  views/mail/           # mail markdown templates
routes/
  panel.php  app.php  web.php  auth.php
config/
  panel-permissions.php # permission registry (name → group + label)
```

---

## How to extend

**Add a member-scoped model.** Create the model and migration, add `$table->foreignUuid('account_id')->constrained()->cascadeOnDelete()` in the migration, and on the model `use App\Concerns\BelongsToAccount;`. That's it — you now have an `account()` relation, queries are auto-scoped to the current account inside the member area, and `account_id` is auto-filled on create. Always create through the Account relation: `$user->account->foos()->create($validated)`. **Never** accept `account_id` from request input.

**Add a permission.** Just add the route and give it a name (`->name('panel.units.index')`). The `route_permission` middleware on the panel group will auto-protect it. Then log in as Super Admin → **Yetkiler → Rotalardan Keşfet** → tick the new route names → save. Edit `group`/`label` in the Yetkiler UI as needed. No config file, no Artisan command. For non-route permissions, click **Yeni İzin** in the same UI.

**Add a notification.** Create a `Send{X}` listener that calls `$notifiable->notify(new {X}Notification(...))`. In the notification: `implements ShouldQueue`, `via=['mail','database']` (or a subset), return a Mailable from `toMail()` (templates in `resources/views/mail/`), write the in-app row via `toArray()`.

**Add media to a model.** `use App\Concerns\HasMedia;`. For an account-owned model, also `use App\Concerns\BelongsToAccount;` and override `mediaAccountCode()` to return `$this->account->code` (so its media lands under that folder). For admin / global owners, the default `media/` folder is used. Then `app(MediaService::class)->attach($owner, $file, 'gallery', private: false)`.

---

## Customization checklist before going live

- [ ] Change seeded admin / member credentials.
- [ ] Set `APP_KEY`, `APP_URL`, `MAIL_*`, real DB credentials.
- [ ] After first login, open **Yetkiler → Rotalardan Keşfet** to import every panel route as a permission, refine the auto-derived `group`/`label` if you wish, then create non-Super-Admin roles in Roller and assign exactly the permissions each role needs. Until permissions are curated, only `Super Admin` can use panel pages (other admins land on the dashboard and 403 elsewhere).
- [ ] Review activity log retention; some events log PII (e.g., old/new email on email change).
- [ ] Configure file storage (`FILESYSTEM_DISK`) — defaults are local; switch to S3 in `config/filesystems.php` if needed.
- [ ] Pick a real queue connection (defaults work but `redis` / `sqs` recommended in production).
- [ ] Localize: keep `lang/en` and `lang/tr` in sync, or remove the one you don't need.
- [ ] Run `composer ci:check` to ensure lint + format + types + tests pass.

---

## Contributing

Issues and PRs welcome. Please run `composer ci:check` before submitting.

## License

MIT — see [LICENSE](LICENSE).
