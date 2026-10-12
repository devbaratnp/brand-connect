# Portal UI/UX Fixes Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix all high- and medium-severity UI/UX defects found in the brand + creator portal audit (broken saves, dead review flow, wrong unread/count signals, 500s on nullable fields, undefined CSS tokens, mobile tables, missing focus states), verified by new feature tests + full suite green.

**Architecture:** No new abstractions. Logic fixes go in existing controllers/routes/model (explicit checks, no new policies); presentation fixes are token swaps and small Blade/CSS edits in `layouts/app.blade.php` + affected views. One new test file covers the behavioral fixes; pure CSS/token swaps are covered by render assertions.

**Tech Stack:** Laravel 13, Blade, PHPUnit 12 (sqlite `:memory:`, `RefreshDatabase`), `Mail::fake()` wherever a touched endpoint sends mail synchronously.

**Conventions locked in by this plan:**
- Currency display is `Rs.` everywhere (matches campaign forms/show/browse/index + landing). The four `$` usages are bugs.
- Campaign statuses are `open|in_progress|closed|cancelled` everywhere (validation, edit form, badges).
- Unread = `read_at === null`, exposed as `Message::is_read` attribute so existing Blade keeps working.
- No new authorization policies (none exist); use explicit `abort`/redirect checks in controllers.

---

## Task 1: Profile save 405 (both roles) + availability value mismatch

**Files:**
- Modify: `routes/web.php:36,40`
- Modify: `app/Http/Controllers/CreatorProfileController.php:43`
- Test: `tests/Feature/PortalFixesTest.php` (new)

**Context:** Both profile forms spoof `@method('PUT')` but routes only accept POST, so every save 405s. The availability dropdown sends `unavailable`, validator only allows `not_available`.

- [ ] **Step 1: Write failing tests** — create `tests/Feature/PortalFixesTest.php` with helpers + first tests:

```php
<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PortalFixesTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    private function makeCampaign(User $brand, array $over = []): Campaign
    {
        return Campaign::create(array_merge([
            'brand_id' => $brand->id,
            'title' => 'Test Campaign',
            'description' => 'A description.',
            'status' => 'open',
        ], $over));
    }

    public function test_creator_can_save_profile_with_unavailable_status(): void
    {
        $creator = $this->makeUser('creator');

        $response = $this->actingAs($creator)->put('/creator/profile', [
            'niche' => 'Fashion',
            'availability' => 'unavailable',
        ]);

        $response->assertRedirect(route('creator.profile'));
        $this->assertDatabaseHas('creator_profiles', [
            'user_id' => $creator->id,
            'availability' => 'unavailable',
        ]);
    }

    public function test_brand_can_save_profile(): void
    {
        $brand = $this->makeUser('brand');

        $response = $this->actingAs($brand)->put('/brand/profile', [
            'company_name' => 'Acme',
        ]);

        $response->assertRedirect(route('brand.profile'));
        $this->assertDatabaseHas('brand_profiles', [
            'user_id' => $brand->id,
            'company_name' => 'Acme',
        ]);
    }
}
```

- [ ] **Step 2: Run to verify failure** — Run: `php artisan test --filter=PortalFixesTest`. Expected: FAIL (405 on both PUTs; validation error on `unavailable`).
- [ ] **Step 3: Implement** — in `routes/web.php`, change line 36 to `Route::put('/creator/profile', ...)` and line 40 to `Route::put('/brand/profile', ...)` (keep names). In `CreatorProfileController.php:43`, change rule to `'availability' => 'nullable|in:available,busy,unavailable'`.
- [ ] **Step 4: Re-run** — Run: `php artisan test --filter=PortalFixesTest`. Expected: PASS (2/2).

---

## Task 2: Message read-state, reply redirect, pagination, compose labels, chat tokens

**Files:**
- Modify: `app/Models/Message.php` (add `is_read` accessor)
- Modify: `app/Http/Controllers/MessageController.php:70` (redirect to conversation)
- Modify: `app/Http/Controllers/DashboardController.php:45-63` (true counts — see Task 5 for view half)
- Modify: `resources/views/layouts/app.blade.php` (add `.bc-sr-only` utility, see Task 7 for the rest)
- Modify: `resources/views/messages/inbox.blade.php`, `sent.blade.php`, `show.blade.php`, `conversation.blade.php`, `create.blade.php`
- Test: append to `tests/Feature/PortalFixesTest.php`

**Context:** `is_read` doesn't exist (only `read_at`), so every inbox row renders "unread" forever. Replying yanks the user to the inbox. Inbox/sent paginate but render no links. Chat bubbles use undefined `var(--bc-*)` tokens (= transparent bubbles).

- [ ] **Step 1: Write failing tests** (append):

```php
public function test_inbox_shows_unread_marker_only_for_unread_messages(): void
{
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');
    Message::create(['sender_id' => $creator->id, 'receiver_id' => $brand->id, 'message' => 'Unread one']);
    Message::create(['sender_id' => $creator->id, 'receiver_id' => $brand->id, 'message' => 'Read one', 'read_at' => now()]);

    $response = $this->actingAs($brand)->get('/messages/inbox');

    $response->assertOk();
    $this->assertSame(1, substr_count($response->getContent(), 'Unread'));
}

public function test_message_store_redirects_back_to_conversation(): void
{
    Mail::fake();
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');

    $response = $this->actingAs($brand)->post('/messages', [
        'receiver_id' => $creator->id,
        'message' => 'Hello',
    ]);

    $response->assertRedirect(route('messages.conversation', $creator));
}

public function test_visiting_message_marks_it_read(): void
{
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');
    $msg = Message::create(['sender_id' => $creator->id, 'receiver_id' => $brand->id, 'message' => 'Hi']);

    $this->actingAs($brand)->get(route('messages.show', $msg))->assertOk();

    $this->assertNotNull($msg->fresh()->read_at);
}
```

- [ ] **Step 2: Run to verify failure** — Run: `php artisan test --filter=PortalFixesTest`. Expected: FAIL (marker count is 2 because `is_read` is always null; redirect goes to inbox; third passes already — it guards the `show()` behavior).
- [ ] **Step 3: Implement model + controller.**
  - `app/Models/Message.php`: add import `use Illuminate\Database\Eloquent\Casts\Attribute;` and method:
    ```php
    protected function isRead(): Attribute
    {
        return Attribute::get(fn () => $this->read_at !== null);
    }
    ```
  - `MessageController.php:70`: replace with `return redirect()->route('messages.conversation', $data['receiver_id'])->with('success', 'Message sent successfully.');`
- [ ] **Step 4: Implement views.**
  - `inbox.blade.php:24`: replace unread inline style with `background:rgba(201,255,85,0.18);` (drop the 3px side-stripe — DESIGN.md bans it). Lines 25/33/37: `var(--bc-bg-alt)` → `var(--soft)`, `var(--bc-text-muted)` → `var(--muted)`, `var(--bc-text)` → `var(--ink)`. Line 42 dot: `background:var(--lime)` + add `<span class="bc-sr-only">Unread</span>` inside the row (after the dot div). Append pagination block after the card:
    ```blade
    @if($messages->hasPages())
        <div class="bc-pagination">{{ $messages->links() }}</div>
    @endif
    ```
  - `sent.blade.php`: same token swaps (lines 25/31/35); append the same pagination block.
  - `show.blade.php`: token swaps (lines 14/22/34/43): `--bc-bg-alt` → `--soft`, `--bc-text-muted` → `--muted`, `--bc-primary` → `--purple`, `--bc-text` → `--ink`.
  - `conversation.blade.php`: line 12 avatar tokens → `--soft`/`--muted`; lines 30/35 timestamps → `--muted`; line 32 bubble: sent `background:var(--ink);color:#fff;`, received `background:var(--paper);color:var(--ink);border:1px solid var(--line);` (keep existing padding/radius/line-height/word-break). Add label before textarea:
    ```blade
    <label class="bc-label" for="reply-message">Reply</label>
    ```
    and give the textarea `id="reply-message"`. Remove Send button inline sizing (`style="height:fit-content;padding:.6rem 1.5rem;"`) so it uses the standard 40px `bc-btn`. Add campaign context note: conversation spans campaigns, so no `campaign_id` is carried (explicitly out of scope).
  - `create.blade.php:26`: option label becomes `{{ $user->name }} — {{ ucfirst($user->role) }}`.
- [ ] **Step 5: Re-run** — Run: `php artisan test --filter=PortalFixesTest`. Expected: PASS.

---

## Task 3: Review flow (dead create route, missing User import, no policy, mouse-only stars)

**Files:**
- Modify: `app/Http/Controllers/ReviewController.php`
- Modify: `routes/web.php:74-75` (add GET create route)
- Modify: `resources/views/reviews/create.blade.php`, `resources/views/reviews/show.blade.php`
- Modify: `resources/views/brand/applications.blade.php`, `resources/views/deliverables/index.blade.php` (entry points)
- Test: append to `tests/Feature/PortalFixesTest.php`

**Context:** No GET create route exists; `create()` calls `$this->authorize('view', ...)` but `app/Policies/` doesn't exist (always 403); `store()` requires `reviewee_id` the form never sends; `show(User $user)` type-hints an unimported `User` (fatal at runtime); stars are `display:none` radios (keyboard-inaccessible).

- [ ] **Step 1: Write failing tests** (append):

```php
public function test_brand_can_open_review_form_and_submit_for_accepted_creator(): void
{
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');
    $campaign = $this->makeCampaign($brand);
    CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id, 'status' => 'accepted']);

    $this->actingAs($brand)
        ->get(route('reviews.create', $campaign) . '?for=' . $creator->id)
        ->assertOk()
        ->assertSee('value="' . $creator->id . '"', false);

    $response = $this->actingAs($brand)->post(route('reviews.store', $campaign), [
        'reviewee_id' => $creator->id,
        'rating' => 5,
        'review' => 'Great work',
    ]);

    $response->assertRedirect(route('campaigns.show', $campaign));
    $this->assertDatabaseHas('reviews', ['reviewer_id' => $brand->id, 'reviewee_id' => $creator->id, 'rating' => 5]);
}

public function test_review_store_rejects_duplicate_and_self_review(): void
{
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');
    $campaign = $this->makeCampaign($brand);
    CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id, 'status' => 'accepted']);

    $payload = ['reviewee_id' => $creator->id, 'rating' => 4];
    $this->actingAs($brand)->post(route('reviews.store', $campaign), $payload)->assertRedirect();
    $this->actingAs($brand)->post(route('reviews.store', $campaign), $payload)->assertSessionHas('error');

    $this->actingAs($brand)->post(route('reviews.store', $campaign), [
        'reviewee_id' => $brand->id, 'rating' => 5,
    ])->assertSessionHas('error');
}

public function test_reviews_show_page_loads(): void
{
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');

    $this->actingAs($brand)->get(route('reviews.show', $creator))->assertOk();
}

public function test_stranger_cannot_open_review_form(): void
{
    $brand = $this->makeUser('brand');
    $stranger = $this->makeUser('creator');
    $campaign = $this->makeCampaign($brand);

    $this->actingAs($stranger)->get(route('reviews.create', $campaign))->assertForbidden();
}
```

- [ ] **Step 2: Run to verify failure** — Expected: FAIL (route missing → 404; `show` fatals on unimported `User`).
- [ ] **Step 3: Implement controller + route.**
  - `ReviewController.php`: add `use App\Models\User;` and `use App\Models\CampaignApplication;`. Replace `create()` with:
    ```php
    public function create(Request $request, Campaign $campaign)
    {
        $this->ensureParticipant($campaign);

        $reviewee = null;
        if ($request->query('for')) {
            $reviewee = User::findOrFail($request->query('for'));
            abort_unless($this->isValidReviewee($campaign, (int) $reviewee->id), 403);
        }

        return view('reviews.create', compact('campaign', 'reviewee'));
    }
    ```
    Add helpers:
    ```php
    private function ensureParticipant(Campaign $campaign): void
    {
        $user = Auth::user();
        $ok = $user->id === $campaign->brand_id
            || CampaignApplication::where('campaign_id', $campaign->id)
                ->where('creator_id', $user->id)
                ->where('status', 'accepted')->exists();
        abort_unless($ok, 403);
    }

    private function isValidReviewee(Campaign $campaign, int $revieweeId): bool
    {
        if ($revieweeId === Auth::id()) {
            return false;
        }
        return $revieweeId === $campaign->brand_id
            || CampaignApplication::where('campaign_id', $campaign->id)
                ->where('creator_id', $revieweeId)
                ->where('status', 'accepted')->exists();
    }
    ```
    In `store()`, after `$request->validate(...)`, insert:
    ```php
    if (! $this->isValidReviewee($campaign, (int) $data['reviewee_id'])) {
        return back()->with('error', 'You can only review the brand or an accepted creator on this campaign.');
    }
    ```
    (Keep the existing duplicate check as-is.)
  - `routes/web.php`: add before the POST reviews line:
    ```php
    Route::get('/campaigns/{campaign}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    ```
- [ ] **Step 4: Implement views.**
  - `reviews/create.blade.php`: line 8 sub-header becomes `Review your experience with <strong>{{ $campaign->title }}</strong>@if($reviewee) — reviewing <strong>{{ $reviewee->name }}</strong>@endif`. After `@csrf`, add `@if($reviewee)<input type="hidden" name="reviewee_id" value="{{ $reviewee->id }}">@endif`. Line 24 star label: `color:var(--bc-text-muted)` → `color:var(--muted)`; line 25 input: replace `style="display:none;"` with `class="bc-sr-only"` (+ keep name/value/checked). Line 59 JS: `'var(--bc-warning, #f59e0b)'` → `'#f59e0b'`, `'var(--bc-text-muted)'` → `'var(--muted)'`. Fieldset: wrap the `#rating-group` div in `<fieldset style="border:none;padding:0;margin:0;"><legend class="bc-sr-only">Rating (1 to 5 stars)</legend> ... </fieldset>` and change the `label.bc-label` "Rating" (line 21) to a `<span class="bc-label" aria-hidden="true">` to avoid a label-without-control (or keep label + add `id` — simplest: keep as-is; the radios have implicit labels via wrapping `<label>` elements, so remove nothing).
  - `reviews/show.blade.php`: line 26 use the passed average: `{{ number_format($averageRating ?? 0, 1) }} average rating ...`. Token swaps lines 20/25/37/43/50/52/54/57: `--bc-bg-alt` → `--soft`, `--bc-text-muted` → `--muted`, `--bc-text` → `--ink`, `--bc-primary` → `--purple`, `--bc-warning` → `#f59e0b`.
  - Entry points: `brand/applications.blade.php` — inside the `@if($application->status === 'pending')` block's `@else`-equivalent, add after the `@endif` of pending (still inside foreach): show for accepted:
    ```blade
    @if($application->status === 'accepted')
        <div style="margin-top: 0.5rem;">
            <a href="{{ route('reviews.create', $campaign) }}?for={{ $application->creator_id }}" class="bc-btn bc-btn-sm bc-btn-ghost">Leave Review</a>
        </div>
    @endif
    ```
    `deliverables/index.blade.php`: next to the View Details button add:
    ```blade
    @if(Auth::user()->isCreator())
        <a href="{{ route('reviews.create', $deliverable->campaign) }}?for={{ $deliverable->campaign->brand_id }}" class="bc-btn bc-btn-sm bc-btn-ghost">Leave Review</a>
    @else
        <a href="{{ route('reviews.create', $deliverable->campaign) }}?for={{ $deliverable->creator_id }}" class="bc-btn bc-btn-sm bc-btn-ghost">Leave Review</a>
    @endif
    ```
- [ ] **Step 5: Re-run** — Run: `php artisan test --filter=PortalFixesTest`. Expected: PASS.

---

## Task 4: Campaign status system (validation, badges, accept/reject transitions)

**Files:**
- Modify: `app/Http/Controllers/CampaignController.php:78`
- Modify: `app/Http/Controllers/ApplicationController.php:101-104`
- Modify: `resources/views/layouts/app.blade.php:89-99` (add 2 badge classes)
- Modify: `resources/views/campaigns/show.blade.php:13-21`, `resources/views/campaigns/index.blade.php:30-38`
- Test: append to `tests/Feature/PortalFixesTest.php`

**Context:** Edit form offers `in_progress` but `update()` rejects it. Dynamic `bc-badge-{{ status }}` emits undefined classes for `in_progress`/`cancelled`. Accepting unconditionally flips campaign to `in_progress` with no revert; `$allStatuses` is dead code.

- [ ] **Step 1: Write failing tests** (append):

```php
public function test_campaign_update_accepts_in_progress_status(): void
{
    $brand = $this->makeUser('brand');
    $campaign = $this->makeCampaign($brand);

    $response = $this->actingAs($brand)->put(route('campaigns.update', $campaign), [
        'title' => 'Test Campaign',
        'description' => 'A description.',
        'status' => 'in_progress',
    ]);

    $response->assertRedirect(route('brand.campaigns'));
    $this->assertSame('in_progress', $campaign->fresh()->status);
}

public function test_rejecting_last_accepted_application_reopens_campaign(): void
{
    Mail::fake();
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');
    $campaign = $this->makeCampaign($brand, ['status' => 'in_progress']);
    $app = CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id, 'status' => 'accepted']);

    $response = $this->actingAs($brand)->post(
        route('applications.update-status', [$campaign, $app]), ['status' => 'rejected']);

    $response->assertRedirect();
    $this->assertSame('open', $campaign->fresh()->status);
}

public function test_rejecting_one_of_two_accepted_keeps_campaign_in_progress(): void
{
    Mail::fake();
    $brand = $this->makeUser('brand');
    $c1 = $this->makeUser('creator');
    $c2 = $this->makeUser('creator');
    $campaign = $this->makeCampaign($brand, ['status' => 'in_progress']);
    CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $c1->id, 'status' => 'accepted']);
    $app2 = CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $c2->id, 'status' => 'accepted']);

    $this->actingAs($brand)->post(
        route('applications.update-status', [$campaign, $app2]), ['status' => 'rejected'])->assertRedirect();

    $this->assertSame('in_progress', $campaign->fresh()->status);
}
```

- [ ] **Step 2: Run to verify failure** — Expected: FAIL (302 back with validation errors on `in_progress`; status stays `in_progress` after last reject).
- [ ] **Step 3: Implement.**
  - `CampaignController.php:78`: `'status' => 'nullable|in:open,in_progress,closed,cancelled',`
  - `ApplicationController.php:101-104`: replace with:
    ```php
    if ($data['status'] === 'accepted') {
        $campaign->update(['status' => 'in_progress']);
    } elseif ($campaign->status === 'in_progress'
        && ! $campaign->applications()->where('status', 'accepted')->exists()) {
        $campaign->update(['status' => 'open']);
    }
    ```
  - Layout badges (after line 92 `.bc-badge-pending`): add
    ```css
    .bc-badge-in_progress { background:#ede9fe; color:#7c3aed; }
    .bc-badge-cancelled { background:#f3f4f6; color:#6b7280; }
    ```
  - `show.blade.php` + `index.blade.php`: insert explicit cancelled branch before `@else`:
    ```blade
    @elseif($campaign->status === 'cancelled')
        <span class="bc-badge bc-badge-cancelled">Cancelled</span>
    ```
    (leaves `@else → pending` as the unknown-status fallback).
- [ ] **Step 4: Re-run** — Run: `php artisan test --filter=PortalFixesTest`. Expected: PASS.

---

## Task 5: Null-safety + wrong-field fixes + dashboard honesty

**Files:**
- Modify: `app/Http/Controllers/DashboardController.php:45-63`
- Modify: `app/Http/Controllers/ApplicationController.php:29-31` (apply-twice redirect)
- Modify: `resources/views/campaigns/show.blade.php`, `browse.blade.php`
- Modify: `resources/views/brand/dashboard.blade.php`, `resources/views/creator/dashboard.blade.php`
- Test: append to `tests/Feature/PortalFixesTest.php`

**Context:** `Carbon::parse(null)` 500s on show/browse when deadline is null (allowed). `number_format(null)` deprecation noise on nullable budgets. Both dashboards read `$message->body` (column is `message`) so previews are blank. Brand stats count capped preview collections; creator "Unread" stat counts all 5 recent messages.

- [ ] **Step 1: Write failing tests** (append):

```php
public function test_campaign_show_renders_with_null_deadline_and_budget(): void
{
    $brand = $this->makeUser('brand');
    $campaign = $this->makeCampaign($brand, ['deadline' => null, 'budget' => null]);

    $this->actingAs($brand)->get(route('campaigns.show', $campaign))->assertOk();
    $this->actingAs($this->makeUser('creator'))->get(route('campaigns.show', $campaign))->assertOk();
}

public function test_brand_dashboard_counts_are_not_capped_by_preview_limits(): void
{
    $brand = $this->makeUser('brand');
    $campaign = $this->makeCampaign($brand);
    for ($i = 0; $i < 12; $i++) {
        $c = $this->makeUser('creator');
        CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $c->id]);
    }

    $response = $this->actingAs($brand)->get('/dashboard');

    $response->assertOk()->assertSee('>12<', false);
}

public function test_creator_dashboard_shows_true_unread_count(): void
{
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');
    Message::create(['sender_id' => $brand->id, 'receiver_id' => $creator->id, 'message' => 'One']);
    Message::create(['sender_id' => $brand->id, 'receiver_id' => $creator->id, 'message' => 'Two', 'read_at' => now()]);

    $response = $this->actingAs($creator)->get('/dashboard');

    $response->assertOk()->assertSee('Unread messages');
}

public function test_applying_twice_redirects_to_my_applications(): void
{
    Mail::fake();
    $brand = $this->makeUser('brand');
    $creator = $this->makeUser('creator');
    $campaign = $this->makeCampaign($brand);
    CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id]);

    $response = $this->actingAs($creator)->post(route('campaigns.apply', $campaign), ['message' => 'Again']);

    $response->assertRedirect(route('creator.applications'));
    $response->assertSessionHas('error');
}
```

- [ ] **Step 2: Run to verify failure** — Expected: FAIL (500 on null deadline; stat shows capped count; unread label missing; redirect goes back to show).
- [ ] **Step 3: Implement controllers.**
  - `DashboardController::brandDashboard`: add
    ```php
    $applicationCount = CampaignApplication::whereIn('campaign_id', $campaigns->pluck('id'))->count();
    $messageCount = Message::where('receiver_id', $user->id)->count();
    ```
    and include both in `compact()`.
  - `DashboardController::creatorDashboard`: add
    ```php
    $unreadCount = Message::where('receiver_id', $user->id)->whereNull('read_at')->count();
    ```
    and include in `compact()`.
  - `ApplicationController::apply` exists-branch: replace `return back()->with('error', ...)` with `return redirect()->route('creator.applications')->with('error', 'You have already applied for this campaign. You can track it below.');`
- [ ] **Step 4: Implement views.**
  - `show.blade.php:38`: `Rs. {{ number_format($campaign->budget, 2) }}` → `{{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 2) : 'Not specified' }}`. Line 42 deadline → `{{ $campaign->deadline ? \Carbon\Carbon::parse($campaign->deadline)->format('M d, Y') : 'Flexible' }}`. Line 65: use the controller's variable — `@if($hasApplied)`. Token swaps lines 9/30/109/114 (`--bc-text-muted` → `--muted`, `--bc-text` → `--ink`, `--bc-bg-alt` → `--soft`, `--bc-primary` → `--purple`). Manage panel (after View Applications link, line 98): add Delete with confirm:
    ```blade
    <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Delete this campaign? This cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bc-btn bc-btn-sm bc-btn-danger">Delete</button>
    </form>
    ```
  - `browse.blade.php`: same budget/deadline guards (lines 38/42); token swaps lines 8/30 (`--bc-text-muted` → `--muted`).
  - `brand/dashboard.blade.php`: stat values use `$applicationCount` / `$messageCount`; line 79 budget → `Budget: {{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 2) : 'Not specified' }}`; line 104 `$message->body` → `$message->message`; Recent Messages rows become links to `messages.conversation` with the sender (`<a href="{{ route('messages.conversation', $message->sender) }}" class="bc-list-item">` replacing the static div, keep inner content); card header gains `<a href="{{ route('messages.inbox') }}" class="bc-btn bc-btn-sm bc-btn-ghost">View All</a>`; messages empty state gains `<a href="{{ route('messages.inbox') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">Go to Inbox</a>`.
  - `creator/dashboard.blade.php`: Messages stat value → `$unreadCount`, label → `Unread messages`, sub → `Needs your attention`; line 108 `$message->body` → `$message->message`; line 132 budget → `${...}` becomes `{{ $campaign->budget !== null ? '$' . number_format($campaign->budget, 0) : 'Budget TBD' }}` — NO: currency standard is Rs. Use `{{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 0) : 'Budget TBD' }}`. Line 143 nested Apply span → `<span style="font-weight:700;color:var(--purple);font-size:13px;">View &amp; Apply →</span>`. Add `@else` to the `@if($campaigns->isNotEmpty())` block (after line 150):
    ```blade
    @else
    <div class="bc-card" style="margin-top: 2rem;">
        <div class="bc-empty">
            <div class="bc-empty-icon"><i class="bi bi-search" style="font-size: 2rem;"></i></div>
            <p class="bc-empty-text">No open campaigns right now</p>
            <p class="bc-empty-sub">New opportunities appear here — check back soon.</p>
        </div>
    </div>
    @endif
    ```
- [ ] **Step 5: Re-run** — Run: `php artisan test --filter=PortalFixesTest`. Expected: PASS.

---

## Task 6: Layout CSS + sidebar a11y + global guards

**Files:**
- Modify: `resources/views/layouts/app.blade.php` (CSS block + sidebar markup + script)

- [ ] **Step 1: Focus ring** — after `.bc-btn-xs` (line 65) insert:
  ```css
  a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible { outline:2px solid var(--purple); outline-offset:2px; }
  ```
- [ ] **Step 2: Tables scroll** — line 81 `.bc-table-wrap { ... overflow:hidden; }` → `overflow-x:auto;`. Add `.bc-table { ... min-width:640px; }` by extending line 82 rule.
- [ ] **Step 3: Card hover scope** — line 68 `.bc-card:hover` → `a:hover .bc-card` (cards are only interactive when wrapped in links, e.g. `campaigns/index`).
- [ ] **Step 4: Toggle resting shadow** — line 38: remove `box-shadow:0 2px 12px rgba(0,0,0,0.06);` from `.bc-sidebar-toggle`, add `.bc-sidebar-toggle:hover { box-shadow:0 2px 12px rgba(0,0,0,0.06); }`.
- [ ] **Step 5: `.bc-sr-only` utility** — append near badges:
  ```css
  .bc-sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0 0 0 0); white-space:nowrap; border:0; }
  ```
- [ ] **Step 6: Sidebar a11y** — line 182 button becomes:
  ```html
  <button class="bc-sidebar-toggle" id="bc-sidebar-toggle" onclick="toggleSidebar()" aria-label="Open navigation" aria-expanded="false" aria-controls="bc-sidebar">
  ```
  line 187 `<aside class="bc-sidebar" id="bc-sidebar">` gains `aria-label="Primary"`. Script: extend `toggleSidebar()` to sync `aria-expanded`, add Esc handler + focus return:
  ```js
  function toggleSidebar(force) {
      var sidebar = document.getElementById('bc-sidebar');
      var overlay = document.getElementById('bc-overlay');
      var toggle = document.getElementById('bc-sidebar-toggle');
      var open = typeof force === 'boolean' ? force : !sidebar.classList.contains('open');
      sidebar.classList.toggle('open', open);
      overlay.classList.toggle('open', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      toggle.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
      if (!open) toggle.focus();
  }
  document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') toggleSidebar(false);
  });
  ```
- [ ] **Step 7: Double-submit guard** — in DOMContentLoaded, add:
  ```js
  document.querySelectorAll('form:not([data-ai-form])').forEach(function(form) {
      form.addEventListener('submit', function() {
          form.querySelectorAll('button[type=submit]').forEach(function(btn) { btn.disabled = true; });
      });
  });
  ```
  (`data-ai-form` excluded: that form submits via fetch with no page reload.)
- [ ] **Step 8: Sidebar icon noise + nav discoverability** — add `aria-hidden="true"` to the `<i>` icons in sidebar links (lines 199-250), and add explicit Profile links: for creators after Deliverables — `<a href="{{ route('creator.profile') }}" ...><i class="bi bi-person" aria-hidden="true"></i> Profile</a>` with `request()->routeIs('creator.profile')` active check; same for brands (`brand.profile`, after Deliverables).
- [ ] **Step 9: Verify** — Run: `composer test`. Expected: full suite green (existing 6 + new ~14).

---

## Task 7: Remaining view polish (tokens, currency, CTAs, confirms)

**Files:** `brand/campaigns.blade.php`, `brand/applications.blade.php`, `brand/profile.blade.php`, `creator/applications.blade.php`, `creator/profile.blade.php`, `campaigns/create.blade.php`, `campaigns/edit.blade.php`, `campaigns/index.blade.php`, `deliverables/index.blade.php`

- [ ] **Step 1: Token swaps** — replace every remaining `var(--bc-text-muted)` → `var(--muted)`, `var(--bc-text)` (and `var(--bc-text, #1f2937)`) → `var(--ink)`, `var(--bc-bg-alt)` → `var(--soft)`, `var(--bc-primary)` (links) → `var(--purple)`, `var(--bc-warning, #f59e0b)` → `#f59e0b`, `var(--bc-muted, #6b7280)` → `var(--muted)` in: `brand/campaigns.blade.php:39`, `brand/applications.blade.php:30`, `creator/applications.blade.php:45`, `campaigns/index.blade.php:28,42-43`. Verify zero remain: `grep -rn "\-\-bc-" resources/views` must return nothing.
- [ ] **Step 2: Currency** — `brand/campaigns.blade.php:46` `${{ number_format($campaign->budget, 2) }}` → `{{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 2) : 'Not specified' }}`. `deliverables/index.blade.php:46` same with `, 0` precision kept. `creator/profile.blade.php:115` label `Price Per Post ($)` → `Price Per Post (Rs.)`.
- [ ] **Step 3: Deliverable badge** — `deliverables/index.blade.php:34` `bc-badge-accepted` → `bc-badge-progress` (purple = in-progress per DESIGN.md). Add brand empty-state CTA after line 25 `@endif`… actually inside the `@if($deliverables->isEmpty())` block for non-creators:
  ```blade
  @if(Auth::user()->isBrand())
      <a href="{{ route('brand.campaigns') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">View Campaigns</a>
  @endif
  ```
- [ ] **Step 4: Forms** — `campaigns/create.blade.php`: remove `required` from `category_id`/`budget`/`deadline` inputs, append ` <span style="font-weight:400;color:var(--muted);">(optional)</span>` inside those three labels; Cancel (line 77) → `route('brand.campaigns')`. `brand/applications.blade.php`: add `onsubmit="return confirm('Reject this application? The creator will be notified.');"` to the Reject form; add `aria-label="Accept application from {{ $application->creator->name }}"` / `aria-label="Reject application from ..."` to the two buttons; empty state gains `<a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-ghost" style="margin-top: 1rem;">Back to Campaign</a>`. Add `@error('status')` block after the button row:
  ```blade
  @error('status')
      <p class="bc-error" style="margin-top:.5rem;">{{ $message }}</p>
  @enderror
  ```
- [ ] **Step 5: Profile back-links** — `brand/profile.blade.php:90-92` and `creator/profile.blade.php:196-198` button rows become `.bc-flex` with a ghost `Back to Dashboard` (`route('dashboard')`) link + the submit button.
- [ ] **Step 6: Creator applications link** — line 16 `route('campaigns.index')` → `route('campaigns.browse')`.
- [ ] **Step 7: Verify** — Run: `composer test` (full suite green) + `grep -rn "\-\-bc-" resources/views` (empty) + `grep -rn "bc-badge-{{\|body," resources/views/creator/dashboard.blade.php resources/views/brand/dashboard.blade.php` (no `$message->body`).

---

## Explicitly deferred (documented, not forgotten)

- Review text `required` client-side vs `nullable` server-side: harmless (stricter client), skip.
- `campaigns/index` "Post Campaign" visible to creators: minor; route guards with 403. Skip (needs product decision on whether creators should see the page at all).
- `browse` badge only for `open`: controller filters to open-only, so moot. Skip.
- Steps/eyebrow/gradient rules in portal views: none found violating (portal uses solid ink headings). No action.
- Commits: repo rule is "commit only when explicitly requested" — no commits in this plan.

## Self-review

1. **Spec coverage:** every high/medium audit item maps to Tasks 1-7 above (profile 405→T1; is_read/redirect/pagination/chat→T2; reviews→T3; status/badges/transitions→T4; nulls/body/counts/apply-twice→T5; layout CSS/a11y/guards→T6; tokens/currency/CTAs/confirms→T7). Deferred list covers the deliberately skipped lows.
2. **Placeholder scan:** all steps name exact files/lines/code/commands; deferred items are explicit rejections with reasons, not TODOs.
3. **Type consistency:** `isRead()` accessor ↔ `is_read` in Blade; `?for=` query param ↔ `create(Request, Campaign)` + hidden `reviewee_id` ↔ `store()` validation; `$applicationCount/$messageCount/$unreadCount/$reviewee/$averageRating` variable names match between controller and view steps; `reviews.create` route name matches entry-point links and tests. `route('messages.conversation', $creator)` passes a User model to a `{user}` binding — consistent with existing `show.blade.php:8` usage.
