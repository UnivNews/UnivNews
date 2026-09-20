# Spec: UnivNews Footer Restructure (About Us & Help)

## 1. Context & Goal

The current footer has 4 columns: **University News** (brand blurb), **Engage** (sign-up CTA), **Social**, **Contact**.

Requested changes:
1. Remove the **Engage** column entirely (the "Don't have an account? ... Create Account" CTA).
2. Move **Social** into the old Engage slot (column 2).
3. Add a new **About Us** column to the right of Social (column 3) — clickable, leads to a page with platform details + vision & mission.
4. Add a new **Help** column to the right of About Us (column 4), with 3 links: **FAQ**, **Contact**, **Privacy Policy**.
5. The old **Contact** column (email/phone/address) is **removed as a standalone column** — its content is merged into the **Help > Contact** page (no message form, just info: WhatsApp number, email, address).

Final footer column order (4 columns):

```
[University News (brand)] [Social] [About Us] [Help]
```

The **About Us** content and the 3 items under **Help** must be **editable from the admin panel** (not hardcoded in Blade).

---

## 2. Database Structure

### 2.1 New table: `site_pages`
Used for **About Us** content, **FAQ** (intro/disclaimer, if needed), and **Privacy Policy** — all single-content pages editable by admin via a plain textarea.

```php
Schema::create('site_pages', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique(); // 'about-us', 'privacy-policy'
    $table->string('title');
    $table->text('content'); // plain text, rendered with nl2br(e())
    $table->timestamps();
});
```

Initial seed:
| slug | title |
|---|---|
| `about-us` | About Us |
| `privacy-policy` | Privacy Policy |

> Note: "About Us" needs separate vision & mission fields (see 2.2), so `site_pages.content` for slug `about-us` is used only for the general description (what UnivNews is, how it works), while vision/mission are stored in dedicated columns so they can be rendered as separate sections on the page.

### 2.2 New columns on `site_pages` (for About Us vision/mission)
Since vision & mission are 2 separate fields and this is a singleton row, two options:

**Option A (recommended, simpler):** add 2 columns to `site_pages`, used only by the `about-us` row:
```php
Schema::table('site_pages', function (Blueprint $table) {
    $table->text('vision')->nullable()->after('content');
    $table->text('mission')->nullable()->after('vision');
});
```
`vision`/`mission` are simply `null` for rows other than `about-us`.

**Option B:** a separate `about_us_settings` table (id, vision, mission, description, updated_at) if you want it fully decoupled from the generic page system. — Pick one; Option A is faster to implement if there are only 2 static pages (about & privacy).

### 2.3 New table: `faqs`
FAQ needs many entries (a Q&A list), not single content, so it gets its own table:

```php
Schema::create('faqs', function (Blueprint $table) {
    $table->id();
    $table->string('category')->nullable(); // 'Readers', 'Authors', 'Payments', 'Technical' — for grouping
    $table->string('question');
    $table->text('answer');
    $table->integer('order')->default(0); // display order
    $table->boolean('is_published')->default(true);
    $table->timestamps();
});
```

### 2.4 Static Contact Info — NO FORM
The **Help > Contact** page just displays 3 static pieces of info: **WhatsApp number**, **Email**, **Address**. There is no message form from reader to admin.

Store as key-value pairs in a `settings` table (reuse an existing settings system if you have one; otherwise a simple table):
```php
Schema::create('settings', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->text('value')->nullable();
    $table->timestamps();
});
```
Keys used: `contact_whatsapp`, `contact_email`, `contact_address`.

> No `contact_messages` table needed, no POST route needed, no rate limiting needed — just a simple 3-field CRUD in admin settings.

---

## 3. Routing

```php
// Public
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('page.about');
Route::get('/help/faq', [PageController::class, 'faq'])->name('page.faq');
Route::get('/help/contact', [PageController::class, 'contact'])->name('page.contact'); // info display only, no POST
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('page.privacy');

// Admin (middleware: auth, role:admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/pages/about', [AdminPageController::class, 'editAbout'])->name('pages.about.edit');
    Route::put('/pages/about', [AdminPageController::class, 'updateAbout'])->name('pages.about.update');

    Route::get('/pages/privacy', [AdminPageController::class, 'editPrivacy'])->name('pages.privacy.edit');
    Route::put('/pages/privacy', [AdminPageController::class, 'updatePrivacy'])->name('pages.privacy.update');

    Route::resource('/faqs', AdminFaqController::class)->except(['show']);

    Route::get('/pages/contact', [AdminContactController::class, 'edit'])->name('pages.contact.edit');
    Route::put('/pages/contact', [AdminContactController::class, 'update'])->name('pages.contact.update');
});
```

---

## 4. Blade Changes — `partials/footer.blade.php`

### 4.1 Column layout (example structure, adapt to existing grid/flex)

```blade
<footer class="site-footer">
    <div class="footer-grid"> {{-- adjust grid-cols to the new column count --}}

        {{-- Column 1: Brand (unchanged) --}}
        <div class="footer-col">
            <h3>University News</h3>
            <p>{{ config('app.tagline') }}</p>
        </div>

        {{-- Column 2: SOCIAL — moved here, REPLACES the old Engage slot --}}
        <div class="footer-col">
            <h4>SOCIAL</h4>
            <ul>
                <li><a href="{{ $socialLinks['instagram'] ?? '#' }}">Instagram</a></li>
                <li><a href="{{ $socialLinks['threads'] ?? '#' }}">Threads</a></li>
                <li><a href="{{ $socialLinks['linkedin'] ?? '#' }}">LinkedIn</a></li>
                <li><a href="{{ $socialLinks['twitter'] ?? '#' }}">X / Twitter</a></li>
            </ul>
        </div>

        {{-- Column 3: ABOUT US — NEW --}}
        <div class="footer-col">
            <h4>ABOUT US</h4>
            <ul>
                <li><a href="{{ route('page.about') }}">Our Story & Mission</a></li>
            </ul>
        </div>

        {{-- Column 4: HELP — NEW --}}
        <div class="footer-col">
            <h4>HELP</h4>
            <ul>
                <li><a href="{{ route('page.faq') }}">FAQ</a></li>
                <li><a href="{{ route('page.contact') }}">Contact</a></li>
                <li><a href="{{ route('page.privacy') }}">Privacy Policy</a></li>
            </ul>
        </div>

    </div>

    {{-- REMOVE the Engage section here entirely --}}

    <div class="footer-bottom">
        <p>© {{ date('Y') }} University News Portal. All academic rights reserved.</p>
        <div>
            <a href="{{ route('page.privacy') }}">Privacy Policy</a>
            <a href="#">Accessibility</a>
        </div>
    </div>
</footer>
```

**Explicit instructions for the agent:**
- [ ] Remove the `<div class="footer-col engage">...</div>` block, including the "Don't have an account? / Create Account" CTA, from `footer.blade.php`.
- [ ] Move the `Social` block into column position 2 (the old Engage slot).
- [ ] Add 2 new column blocks: `About Us` (column 3) and `Help` (column 4), per the example above.
- [ ] Remove the old `Contact` column from the footer entirely (contact info now only lives on the `Help > Contact` page, not directly in the footer).
- [ ] Update the grid CSS (`grid-template-columns` / flex basis) to fit the new column count (4 columns), and check the responsive wrap breakpoint on mobile.
- [ ] The existing "Privacy Policy" link in footer-bottom should point to the same `page.privacy` route — don't create a duplicate route.

---

## 5. Public Pages to Build

### 5.1 `pages/about.blade.php` (About Us)
Content:
- Page title
- "What is UnivNews" section → from `site_pages.content` (slug `about-us`)
- "Vision" section → from `site_pages.vision`
- "Mission" section → from `site_pages.mission` (render as a list if stored as multiple lines)
- (Optional) Section listing member universities — query from the `universities` table

### 5.2 `pages/faq.blade.php`
- Fetch all `Faq::where('is_published', true)->orderBy('order')->get()->groupBy('category')`
- Render as an accordion per category
- If category is empty/null, group under "General"

### 5.3 `pages/contact.blade.php`
- Simple display, no form. Just 3 lines of info:
  - WhatsApp number (can be a clickable `https://wa.me/62...` link)
  - Email (can be a `mailto:` link)
  - Address
- Pulled from the `settings` table (keys: `contact_whatsapp`, `contact_email`, `contact_address`)
- Follow the same visual style as the old Contact footer column (icon + text) for consistency, even though it's now its own page.

### 5.4 `pages/privacy.blade.php`
- Render `site_pages.content` (slug `privacy-policy`) with `{{ nl2br(e($page->content)) }}` since it's plain text input (see section 6/7).

---

## 6. Admin Panel — New Menu

Add a new admin sidebar menu: **Site Content** (or group it however fits the existing admin structure), with 4 sub-items:

All content editors below use a **plain textarea** (no WYSIWYG/rich text) — consistent with the other form components already in the admin panel. The textarea content is rendered as-is on the reader side, following the already-designed section styling (line breaks become new paragraphs, etc. — use `nl2br(e($text))` in Blade, not raw `{!! !!}`, so it stays safe from HTML injection since the input is plain text).

### 6.1 Edit About Us
Form with 3 fields, all `<textarea>`:
- **Description/Profile** → `site_pages.content` where slug=`about-us`
- **Vision** → `site_pages.vision`
- **Mission** → `site_pages.mission` (if you want it shown as a list, have the admin put each mission point on its own line, then `explode("\n", ...)` in Blade)

### 6.2 Manage FAQ (full CRUD)
FAQ list table with columns: Category, Question, Status (published/draft), Order, Actions (edit/delete).
Create/edit form: `category` (dropdown/text), `question` (text input), `answer` (`<textarea>`), `order` (number), `is_published` (toggle).
Add a reorder feature (drag-and-drop or manual `order` input) so the admin can control display order.

### 6.3 Edit Privacy Policy
Single `<textarea>` form → `site_pages.content` where slug=`privacy-policy`.

### 6.4 Edit Contact Info
Simple 3-field form (not WYSIWYG, plain text inputs since it's one line per field):
- **WhatsApp Number** → `settings.contact_whatsapp`
- **Email** → `settings.contact_email`
- **Address** → `settings.contact_address` (small `<textarea>` if the address is long)

No "view incoming messages" feature is needed, since there's no contact form from readers — the Contact page is purely informational.

---

## 7. Validation & Business Rules

- `site_pages` and `faqs` content does **not** need an approval workflow like articles — the `admin` role can edit directly (unlike the author article flow, which requires review).
- Since all input uses **plain textareas** (no WYSIWYG), render to Blade with `{{ nl2br(e($text)) }}` — not `{!! !!}` — so HTML is still escaped but line breaks still read as new paragraphs. This also removes any XSS risk without needing an extra sanitizer library (e.g. `mews/purifier`).
- FAQ category should use a fixed list/`enum` in validation (e.g.: `Readers`, `Authors`, `Payments`, `Technical`) so grouping on the public page stays consistent, instead of free text that could vary/typo between admins.
- WhatsApp number validation in settings: digits only (optionally prefixed with `+`), so the generated `wa.me/...` link is valid.

---

## 8. Decisions Already Made (recap)

1. ✅ The old Contact info is **removed from the footer**, merged into the **Help > Contact** page content (WhatsApp, Email, Address only).
2. ✅ All admin content fields (About Us, Privacy, FAQ) use **plain textareas**, not WYSIWYG. The reader-facing display follows the existing design.
3. ✅ The Contact page has **no form** — readers don't send messages to the admin through the site, it's just contact info on display.

## 9. Open Question — Bilingual UI

**Not yet decided:** does the UI (outside of article content) need to be bilingual ID/EN for this release, or should it be deferred as a separate task after this footer/Help/About Us structure is done?

Recommendation: **defer it**, build this spec as single-language first, matching the existing design. If bilingual support is added later, the impact on this spec would be:
- `site_pages` & `faqs` would need duplicate columns per language (`content_en`, `vision_en`, `mission_en`, `question_en`, `answer_en`) or a separate translations table
- The `settings` table (WhatsApp/Email/Address) usually doesn't need to be bilingual (factual data, same across languages) — unless the address label itself needs translating
- The admin forms in section 6 would need 2 fields/tabs per language
- If you decide to go bilingual from the start, let me know — I'll update the migration & form spec before handing it to the coding agent, so there's no need to re-migrate later.

---

## 10. Implementation Checklist

- [ ] Migrations: `site_pages` (+ `vision`, `mission` columns), `faqs`, `settings` (if not already present)
- [ ] Seeders: default `about-us` & `privacy-policy` rows in `site_pages`; `contact_whatsapp`/`contact_email`/`contact_address` keys in `settings`
- [ ] Models: `SitePage`, `Faq`, `Setting`
- [ ] Public + admin routes (see section 3)
- [ ] Public controller: `PageController` (about, faq, contact, privacyPolicy)
- [ ] Admin controllers: `AdminPageController`, `AdminFaqController`, `AdminContactController` (edit contact settings)
- [ ] Public views: `pages/about.blade.php`, `pages/faq.blade.php`, `pages/contact.blade.php` (info only, no form), `pages/privacy.blade.php`
- [ ] Admin views: edit-about form (textarea), edit-privacy form (textarea), FAQ CRUD (textarea for answer), edit-contact-info form
- [ ] Update `partials/footer.blade.php`: remove Engage, remove the Contact column, move Social to column 2, add About Us (column 3) & Help (column 4)
- [ ] Update footer grid/CSS for 4 columns
- [ ] Render all admin-authored text with `nl2br(e($text))`, not `{!! !!}`
- [ ] Decide on bilingual UI (section 9) before or after this task — update migrations accordingly once decided
