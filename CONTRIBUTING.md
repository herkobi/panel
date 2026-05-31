# Contributing

Thanks for working on **Herkobi**. This file covers the workflow and the quality
bar. For *what the system is and how it's built*, read **[AGENTS.md](AGENTS.md)**
first — the rules there are not optional.

## Setup

```bash
composer setup     # deps, .env, key, migrate, build
composer dev       # serve + queue + vite
```

Tests run on SQLite `:memory:` with `array` cache/session and `sync` queue — no
extra services required.

## Workflow

1. **Branch** off the default branch; never commit straight to it.
2. Make the change, following the architecture rules in AGENTS.md.
3. **Regenerate typed routes** if you touched routes:
   `php artisan wayfinder:generate --with-form --no-interaction`.
4. **Keep `lang/tr` and `lang/en` in sync** for any user-facing string (Turkish is primary).
5. Add/adjust **Pest** tests for behavior changes (feature tests use `RefreshDatabase`).
6. Run the full check locally before opening a PR:
   ```bash
   composer ci:check   # ESLint + Prettier + tsc + Pest
   ```
7. Open a PR with a clear description and the passing-check summary.

## Code style

- **PHP** — Pint (Laravel preset). Every file `declare(strict_types=1);`. Models use
  `HasUuids` and PHP 8.4 attributes (`#[Fillable]`, `#[Scope]`, …). `CarbonImmutable`.
- **TypeScript / React** — ESLint + Prettier. Strict TS, alias `@/* → resources/js/*`.
  Do **not** hand-edit `resources/js/components/ui/*` (shadcn-generated).
- **Types** — shared / duplicated / backend-reflecting types go in `@/types`; page
  `Props` and trivial one-off shapes stay inline. Reuse `Option<T>` for `{value,label}`.
- **Commits** — small, focused, imperative subject lines.

## The rules that bite if ignored

- **Side effects only via `event() → listener`** (auto-discovered) — not from controllers/services.
- **`account_id` never comes from request input** — use the bound account or the Account relation.
- **New panel routes are auto-protected** by `route_permission` (route name = permission
  name) and reachable only by Super Admin until an admin curates the permission from
  **Yetkiler → Rotalardan Keşfet**. Personal `panel.profile.*` routes are exempt.
- **Email/notifications** — a `ShouldQueue` Notification whose `toMail()` returns a
  Mailable, triggered by a `Send{X}` listener via `notify()`. Don't wrap routine mail in a Job.
- **Destructive UI actions confirm first** via the `ConfirmDelete` component.
- **Branding** (app name / logo / favicon) is read from `App\Support\Branding`, never
  hardcoded; favicon is used only in the sidebar, the logo everywhere else.
- **Extend through the module system**, not by editing core: contribute menu / permissions /
  routes from a provider via the `{area}.menu.register` / `{area}.permissions.register` /
  `{area}.routes.register` hooks. Never hardcode the sidebar or hand-edit the `navigation` prop.

## Don't delete the scaffolding

Herkobi is a starter kit, so some complete pieces ship **unused on purpose** — the
full shadcn/ui set, the `useCan` / `useHasRole` / `useIsSuperAdmin` permission hooks,
the `*_LABEL` / `*_OPTIONS` / `*_VALUES` enum helpers, the alternative layouts, and
`media-gallery`. These are there so a consumer can reach for them immediately; do
**not** remove them as "dead code" during cleanup. See *Intentional scaffolding* in
AGENTS.md.

## Definition of done

- `composer ci:check` is green.
- Routes regenerated (if changed); `tr`/`en` strings in sync.
- Behavior covered by tests; no `components/ui/*` hand-edits; no hardcoded URLs or branding.
