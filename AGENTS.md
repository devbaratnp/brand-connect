# AGENTS.md — Brand Connect (Laravel)

## Stack
- Laravel 13 (`laravel/framework ^13.8`), PHP `^8.3`. Default DB is **SQLite** (`DB_CONNECTION=sqlite`); session/cache/queue drivers are `database`. Mail is `log` locally.
- Frontend: Blade in `resources/views/` + Vite + Tailwind v4 (`resources/css/app.css`, `resources/js/app.js`). App UI styling lives mostly in custom `bc-*` classes inside `resources/views/layouts/app.blade.php`, not Tailwind utilities.
- Design source of truth: `DESIGN.md` (lime `#c9ff55` ≤10% of screen, flat surfaces, Instrument Sans) and `PRODUCT.md`. Honor them on any UI work.

## Commands
- First-time setup: `composer setup` (install, key, migrate, `npm install`, `npm run build`).
- Dev (serve + queue + logs + vite concurrently): `composer dev`
- Build frontend: `npm run build`; dev: `npm run dev`
- Tests: `composer test` (= `php artisan config:clear` + `php artisan test`). Single test: `php artisan test --filter=TestName` (e.g. `php artisan test --filter=AiAssistantTest`).
- Format PHP: `vendor/bin/pint` (no composer shortcut). No lint/typecheck script.
- Migrations: `php artisan migrate`; fresh+seed: `php artisan migrate:fresh --seed`

## Architecture
- Entry: `routes/web.php` (only route file; no `api.php`). Almost everything except `/`, `/login`, `/register`, `/ai/chat` is under `auth` middleware.
- Roles are a string column `users.role` (`creator`|`brand`|`admin`) with `User::isBrand()/isCreator()/isAdmin()`. `/admin/*` routes have **no separate admin middleware** — each `AdminController` action must re-check role; preserve that pattern.
- Domain models in `app/Models/`: `User`, `Campaign` (belongs to brand via `brand_id`), `CampaignApplication` (creator↔campaign, `status`), `Message`, `Review`, `Category`, `CreatorProfile`/`BrandProfile`.
- AI assistant: `POST /ai/chat` → `AiController` → `App\Services\AiAssistantService` → Groq OpenAI-compatible endpoint. Config in `config/ai.php`, env `AI_ENABLED` / `GROQ_API_KEY` / `GROQ_MODEL` (default `llama-3.3-70b-versatile`). Returns `{reply, error}` where error ∈ `missing_key|api_error|exception|null`. History capped at last 10 turns / 2000 chars each; keep both caps when touching it.

## Testing notes
- `phpunit.xml` forces sqlite `:memory:`, `array` cache/session, `sync` queue — no external services needed. Use `RefreshDatabase` trait + `Http::fake(['api.groq.com/*' => ...])` for AI tests (see `tests/Feature/AiAssistantTest.php`).
- `.env` is gitignored — never commit it; copy from `.env.example` for setup.
