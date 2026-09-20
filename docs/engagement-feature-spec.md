# UnivNews — Like, Comment & Share Feature Spec

## 1. Overview

Adds three engagement mechanisms to published articles:

1. **Like** — toggle like/unlike on an article. Requires login (any role: reader, author, admin).
2. **Comment** — post plain-text comments on an article. Requires login. No pre-moderation (shown immediately), but admin can delete.
3. **Share** — share article to social platforms (WhatsApp, Facebook, X) via share links, plus copy-link fallback.

Scope: only applies to articles with `status = 'published'`. Draft/pending articles are not engageable.

---

## 2. Database Schema

### 2.1 `article_likes`

| Column | Type | Notes |
|---|---|---|
| id | bigint, PK | |
| article_id | bigint, FK → articles.id, cascade on delete | |
| user_id | bigint, FK → users.id, cascade on delete | |
| created_at | timestamp | |

- Unique constraint on (`article_id`, `user_id`) — one like per user per article (toggle, not counter).
- No `updated_at` needed (row is deleted on unlike, not updated).
- Index on `article_id` for fast like-count aggregation.

### 2.2 `article_comments`

| Column | Type | Notes |
|---|---|---|
| id | bigint, PK | |
| article_id | bigint, FK → articles.id, cascade on delete | |
| user_id | bigint, FK → users.id, cascade on delete | |
| body | text | plain text, max 1000 chars (enforced at validation) |
| is_hidden | boolean, default false | soft-hide by admin instead of hard delete (keeps audit trail) |
| created_at | timestamp | |
| updated_at | timestamp | |

- Index on `article_id`.
- No nested replies in this version (flat comment list only) — see Open Questions.

### 2.3 No new table for share

Share is stateless (just generates URLs client-side). Optional: a `share_events` table if vall wants share-click analytics later — not included in MVP per current scope.

---

## 3. Business Rules

### Like
- One like per user per article. Clicking again = unlike (toggle via delete row).
- Like count = `COUNT(*)` on `article_likes` for that article (cache-friendly, can be denormalized later if performance becomes an issue — not needed at current scale).
- Guest (not logged in) clicking like → redirected to login, with `intended` URL back to the article.

### Comment
- Body required, 1–1000 chars, plain text (no HTML/markdown rendering — same `nl2br(e($text))` pattern used in footer content per project convention).
- No pre-moderation queue — comment appears immediately after submit.
- Rate limit: max 1 comment per 10 seconds per user (throttle middleware) to prevent spam/flooding, since there's no moderation gate.
- Admin can hide a comment (`is_hidden = true`) — hidden comments excluded from public queries but retained in DB.
- Comment author can delete their own comment (soft — sets `is_hidden = true` as well, same field reused).
- No editing in this version (delete + repost only) — see Open Questions.

### Share
- Share buttons generate pre-filled share URLs:
  - WhatsApp: `https://wa.me/?text={encoded article title + URL}`
  - Facebook: `https://www.facebook.com/sharer/sharer.php?u={encoded URL}`
  - X: `https://twitter.com/intent/tweet?text={encoded title}&url={encoded URL}`
- "Copy link" button copies canonical article URL to clipboard (JS `navigator.clipboard.writeText`), with a small toast/feedback confirming copy.
- No login required to view/use share buttons (share is a public-facing action, unlike like/comment which require auth per vall's decision).
- Article must have proper Open Graph meta tags (`og:title`, `og:description`, `og:image`) so shared links render previews correctly — check this exists in the article Blade layout; if not, add it as part of implementation.

---

## 4. API / Routes

| Method | Route | Middleware | Description |
|---|---|---|---|
| POST | `/articles/{article}/like` | `auth` | Toggle like for current user |
| GET | `/articles/{article}/likes/count` | none | Get like count (for async refresh, optional) |
| POST | `/articles/{article}/comments` | `auth`, `throttle:comment` | Create comment |
| DELETE | `/comments/{comment}` | `auth` | Soft-delete own comment (or admin any comment) |
| GET | `/articles/{article}/comments` | none | Paginated list of visible comments (for lazy-load, optional) |

- `throttle:comment` = custom throttle middleware, 1 request per 10 seconds per user, defined in `RouteServiceProvider` or `bootstrap/app.php` depending on Laravel version in use.
- Authorization: comment delete uses a Policy (`CommentPolicy::delete`) checking `$comment->user_id === $user->id || $user->role === 'admin'`.

---

## 5. Frontend / UI

- Like button: heart/thumb icon, filled state if current user has liked, with live count next to it. AJAX toggle (no full page reload) — Blade + small JS fetch, consistent with existing project pattern (no SPA framework in use).
- Comment section: below article body. List of comments (author name, timestamp, body), textarea form at top or bottom for logged-in users; "Login to comment" prompt for guests.
- Share buttons: icon row (WhatsApp, Facebook, X, Copy Link) — likely placed near the like button and/or floating on scroll for long articles (design detail, flag to vall during implementation).

---

## 6. Implementation Checklist

1. Migration: `article_likes` table.
2. Migration: `article_comments` table.
3. Models: `ArticleLike`, `ArticleComment` (+ relations on `Article` and `User` models: `likes()`, `comments()`, `likedBy()`).
4. `LikeController::toggle()` — check existing like, delete or create, return JSON `{ liked: bool, count: int }`.
5. `CommentController::store()` — validate, create, return comment partial/JSON.
6. `CommentController::destroy()` — authorize via policy, soft-hide.
7. `CommentPolicy` registration.
8. Throttle middleware for comment posting.
9. Blade partials: like button, comment list + form, share button row.
10. Add Open Graph meta tags to article layout (if not already present) for proper share previews.
11. JS: AJAX for like toggle, comment submit (optional: without full reload), clipboard copy for share.
12. Admin panel: add "hide comment" action in article/comment management view.
13. Test: like toggle idempotency, comment rate limit, guest redirect-to-login flow, admin hide comment.

---

## 7. Open Questions (unresolved — flagged for vall)

- **Comment editing**: currently spec'd as delete-only (no edit). Confirm if edit is needed.
- **Nested replies**: flat comment list only in this version. Confirm if threaded replies are needed later (would need `parent_id` column — easy to add now if planned, harder to retrofit ordering/UI later).
- **Notifications**: should article author get notified when their article receives a like/comment? Not in scope currently — flag for future.
- **Guest share tracking**: no analytics on share clicks in this version. Add `share_events` table later if needed.
- **Comment length limit**: assumed 1000 chars — confirm if different limit preferred.
- **Rate limit value**: assumed 1 comment / 10 seconds — adjust if too strict/loose.
