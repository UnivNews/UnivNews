# Article Boost Feature — Implementation Spec

## 1. Overview

A monetization add-on on top of the existing pay-per-publish model. An **author** can pay to
"boost" one of their **already-published** articles so it appears in a **limited-capacity
Featured section on the homepage**, for a date range the author chooses in advance.

Key properties:
- Only articles with `status = published` are eligible.
- Author picks a **start date** and a **duration option** (3 days / 1 week / 1 month). The
  price per duration option is configured by admin (not hardcoded, not user-input).
- The boost does **not** start immediately after payment — it starts on the date the author
  selected. This is a **booking/reservation system**, not an instant toggle.
- The homepage Featured section has a **hard cap of 5 concurrent slots**. When an author picks
  a date range, the system checks slot availability across that range and **auto-assigns** the
  booking to any free slot — the author never picks a slot number directly.
- A background scheduler activates bookings whose start date has arrived, and expires bookings
  whose end date has passed.

### 1.1 User Flow (explicit order)

1. Author selects which of their **published** articles to boost.
2. Author is shown a **calendar** for that article's boost, showing which date ranges currently
   have free capacity (out of the 5 concurrent slots).
3. On the same screen, author picks a **duration option** (3 days / 1 week / 1 month) —
   there is no tiering/pricing logic beyond these 3 fixed options, admin sets the price for each.
4. Author proceeds to **payment immediately** (not "book now, pay later, then get a queue").
5. Once payment is confirmed (via Mayar webhook), author receives an **email** confirming the
   boost is active/scheduled and stating the exact start date it will go live.

Note: booking (step 2–3) and payment (step 4) happen in the same session — there is no
"reserve now, pay whenever" state exposed to the author. Internally the record still passes
through `pending_payment` briefly, but the UX is a single continuous flow.

Out of scope for this iteration (confirm before building if needed):
- Bidding / tier-based override of existing boosts
- Per-day custom pricing (pricing is fixed per duration option, admin-configurable)
- Cancellation/refund flow (not discussed yet — flag this as an open question)

---

## 2. Database Schema

### 2.1 `boost_prices` (admin-configurable pricing)

Admin sets/updates the price for each of the 3 fixed duration options. Seed with 3 rows; don't
hardcode prices in code.

```php
Schema::create('boost_prices', function (Blueprint $table) {
    $table->id();
    $table->enum('duration_type', ['3_days', '1_week', '1_month'])->unique();
    $table->unsignedInteger('duration_days'); // 3, 7, 30 — denormalized for easy date math
    $table->unsignedBigInteger('price'); // in Rupiah, smallest unit, server-side source of truth
    $table->boolean('is_active')->default(true); // admin can disable an option without deleting it
    $table->timestamps();
});
```

Seeder example:

```php
DB::table('boost_prices')->insert([
    ['duration_type' => '3_days',  'duration_days' => 3,  'price' => 50000,  'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
    ['duration_type' => '1_week',  'duration_days' => 7,  'price' => 100000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
    ['duration_type' => '1_month', 'duration_days' => 30, 'price' => 350000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
]);
```

### 2.2 `boosts` (the reservation record)

```php
Schema::create('boosts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->comment('author who purchased the boost');
    $table->foreignId('boost_price_id')->constrained(); // snapshot which option was chosen

    // Snapshot fields — never trust boost_prices at read time for a confirmed booking,
    // in case admin changes prices later. Copy values in at creation time.
    $table->string('duration_type');
    $table->unsignedInteger('duration_days');
    $table->unsignedBigInteger('price_paid');

    $table->date('start_date');
    $table->date('end_date'); // = start_date + duration_days, computed server-side

    $table->unsignedTinyInteger('slot_number')->nullable(); // 1–5, assigned on confirmation
    $table->enum('status', [
        'pending_payment',  // booking created, waiting for payment
        'scheduled',        // paid, start_date is in the future
        'active',           // paid, currently within start_date–end_date, showing on homepage
        'expired',          // end_date has passed
        'cancelled',        // payment failed / abandoned
    ])->default('pending_payment');

    $table->timestamps();

    $table->index(['status', 'start_date', 'end_date']);
});
```

### 2.3 `boost_payments`

Reuses the same pattern as the existing `payments` table (multiple attempts per boost, webhook
as source of truth). Keep it as its own table rather than overloading the article `payments`
table, since this is a different payment purpose.

```php
Schema::create('boost_payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('boost_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained();
    $table->string('mayar_transaction_id')->nullable();
    $table->unsignedBigInteger('amount'); // server-side, copied from boost.price_paid
    $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
    $table->timestamps();
});
```

---

## 3. Core Business Rules

1. **Eligibility**: only the article's owning author can boost it, and only if
   `article.status === 'published'`.
2. **Price is always server-derived** from `boost_prices` at the time of booking creation —
   never trust a price sent from the client. Snapshot it into `boosts.price_paid`.
3. **Availability check (the important part)**: for a requested `[start_date, end_date]` range,
   count how many *existing* boosts (`status IN ('scheduled', 'active')`) overlap that range.
   If the overlap count for any day in the range reaches 5, that range is unavailable.
   - This should be validated **twice**: once when showing the calendar (soft, UX only), and
     again inside a DB transaction at booking-confirmation time (hard, source of truth) to
     avoid race conditions between two authors booking the same slot concurrently.
4. **Slot number is cosmetic**, assigned only for admin/debug visibility (e.g. "Slot 3 of 5") —
   the actual guarantee of "max 5 concurrent" comes from the overlap-count check in rule 3, not
   from slot_number uniqueness enforcement. Simplest safe implementation: don't pre-assign fixed
   slot IDs at all; just query concurrent count. Assign `slot_number` as
   `(current concurrent count at start_date) + 1` purely for display purposes.
5. **Boost only activates once payment is confirmed via webhook** — same principle as article
   publication. A `pending_payment` boost does NOT reserve a slot; only `scheduled`/`active`
   boosts count toward the 5-slot cap. This avoids abandoned bookings clogging availability.
6. **Homepage Featured query**: articles where there exists a `boosts` row with
   `status = 'active'` (i.e., `start_date <= today <= end_date` AND payment confirmed), ordered
   by `start_date ASC` (earliest-started boost shown first) or however you want to break ties —
   confirm this ordering with the team since it wasn't specified.

---

## 4. API Endpoints

### 4.1 `GET /api/articles/{article}/boost/availability?start_date=&duration_type=`
Returns whether the requested range is available, and optionally a calendar of daily
concurrent-boost counts for the next N days so the frontend can render a visual calendar
(e.g. green/red days). Server computes `end_date` from `duration_type`.

### 4.2 `POST /api/articles/{article}/boost`
Body: `{ duration_type, start_date }`.
- Validates article ownership + `published` status.
- Re-validates availability inside a DB transaction (row-lock relevant date range or use
  `SELECT ... FOR UPDATE` pattern on overlapping rows to prevent race conditions).
- Creates `boosts` row with `status = pending_payment`, snapshots price from `boost_prices`.
- Creates a Mayar invoice (reuse `MayarService` from the article payment flow) and returns the
  payment URL.

### 4.3 `POST /webhooks/mayar/boost` (or extend the existing webhook handler with a type check)
- On success: within `DB::transaction()`, update `boost_payments.status = success` and
  `boosts.status = scheduled` (or `active` if `start_date <= today`).
- Re-check availability one more time here before confirming — if somehow oversold due to a
  race condition, this is the last line of defense (flag to admin / auto-refund path is a
  decision to make later).
- **After the transaction commits successfully**, dispatch a `BoostActivatedMail` (or similarly
  named Mailable) to the author via Resend, confirming the boost purchase and stating the exact
  `start_date`/`end_date`. Since queue is `sync` for now, this send happens inline — keep it
  outside the DB transaction itself so a slow mail send can't hold a DB lock.
- Follow the same test-mode constraint as existing email flows: in Resend test mode, the
  recipient must match the account email.

### 4.4 `GET /api/homepage/featured`
Public endpoint. Returns articles with an `active` boost per rule 6 above.

### 4.5 Admin: manage boost prices

`GET /api/admin/boost-prices`
Returns all 3 rows from `boost_prices` (id, duration_type, duration_days, price, is_active).

`PUT /api/admin/boost-prices/{boostPrice}`
Body: `{ price, is_active }`.
- Admin-only (middleware/policy check — `role === 'admin'`).
- Only `price` and `is_active` are editable. `duration_type`/`duration_days` are fixed (3 rows
  seeded, not creatable/deletable) since there's no tiering system beyond these 3 options.
- Updating a price here **only affects future bookings** — existing `boosts` rows already have
  their price snapshotted in `price_paid`, so past/active boosts are untouched. No cascading
  update needed.
- No need for a `POST` (create) or `DELETE` endpoint — the 3 duration options are fixed by
  design, not admin-manageable as a list.

---

## 5. Scheduler (new component — doesn't exist in current codebase)

Two scheduled jobs needed, run via Laravel's scheduler (`app/Console/Kernel.php`), running at
least daily (hourly if you want same-day activation to feel prompt):

```php
$schedule->call(function () {
    Boost::where('status', 'scheduled')
        ->where('start_date', '<=', now()->toDateString())
        ->update(['status' => 'active']);
})->hourly();

$schedule->call(function () {
    Boost::where('status', 'active')
        ->where('end_date', '<', now()->toDateString())
        ->update(['status' => 'expired']);
})->hourly();
```

⚠️ Since queue is currently `sync` and there's no Supervisor worker yet, confirm the Laravel
scheduler (cron entry `* * * * * php artisan schedule:run`) is set up in the dev/prod
environment — this is a separate mechanism from queue workers and easy to forget.

---

## 6. Open Questions Before Implementation

1. **Cancellation/refund**: can an author cancel a scheduled (not-yet-active) boost? Does Mayar
   support refunds, or is this "no refund" by policy?
2. **Tie-breaking order** on the homepage when multiple boosts are active — earliest start date
   first, or something else (e.g. most recently activated)?
3. Should `boost_prices` support **admin disabling** a duration option without affecting
   already-confirmed boosts using the old price? (Schema above already handles this via
   snapshotting — just confirming the intent.)
4. What happens if an author tries to boost an article that later gets **unpublished/rejected**
   after the boost was already scheduled or is currently active? Suggest: auto-expire the boost
   if article status changes away from `published`.

---

## 7. Implementation Checklist

- [ ] Migration: `boost_prices` + seeder with 3 default options
- [ ] Migration: `boosts`
- [ ] Migration: `boost_payments`
- [ ] Model relationships: `Article hasMany Boost`, `Boost belongsTo Article/User/BoostPrice`,
      `Boost hasMany BoostPayment`
- [ ] Availability-check service (concurrent count per day, with transaction-safe re-check)
- [ ] `POST /api/articles/{article}/boost` endpoint + form request validation
- [ ] `GET .../boost/availability` endpoint for calendar UI
- [ ] Extend/duplicate `MayarService` invoice creation for boost payments
- [ ] Webhook handler branch for boost payment confirmation (atomic transaction, re-check
      availability, set `scheduled`/`active`)
- [ ] `BoostActivatedMail` Mailable + Resend send, dispatched after webhook transaction commits
      (states confirmed start/end date)
- [ ] Scheduler jobs: activate + expire boosts (hourly)
- [ ] Confirm cron `schedule:run` is registered in the environment
- [ ] `GET /api/homepage/featured` endpoint
- [ ] Admin UI/endpoint to edit `boost_prices` (`GET`/`PUT /api/admin/boost-prices`, admin-only
      middleware, only `price` + `is_active` editable — see Section 4.5)
- [ ] Resolve open questions in Section 6 before writing cancellation/edge-case logic
