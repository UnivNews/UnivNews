# University News Portal — Agent-Ready Project Specification

> **Document Type:** AI Coding Agent Specification
> **Project:** University News Portal & CMS
> **Primary IDE:** Antigravity IDE
> **Backend:** Laravel
> **Database:** PostgreSQL
> **Frontend:** Blade + Tailwind CSS + Alpine.js
> **Build Tool:** Vite
> **Status:** Ready for Agent Implementation

---

# 1. PROJECT OBJECTIVE

Build a modern, authoritative, responsive university news portal with an integrated Content Management System (CMS).

The system must provide two major areas:

1. **Public News Portal**
   - University news homepage
   - News categories
   - Research & Innovation section
   - Article detail pages
   - Breaking news
   - Trending research
   - Search and filtering
   - Responsive layouts

2. **Admin CMS**
   - Authentication
   - Dashboard
   - Article management
   - Article editor
   - Categories
   - Tags
   - User/author management
   - Publishing workflow
   - Scheduled publishing
   - Draft management
   - Article statistics

The final implementation must be production-oriented, maintainable, responsive, accessible, and visually consistent with the provided design references.

---

# 2. IMPORTANT AGENT INSTRUCTIONS

These rules are mandatory.

## 2.1 Inspect Before Modifying

Before writing or modifying code:

1. Inspect the existing project structure.
2. Determine whether Laravel has already been initialized.
3. Inspect `composer.json`.
4. Inspect `package.json`.
5. Inspect `.env` and `.env.example`.
6. Inspect existing routes, models, migrations, controllers, Blade views, and components.
7. Inspect all provided design reference images.

Do not blindly overwrite existing files.

If the project is empty, initialize the Laravel application according to the project requirements.

---

## 2.2 Design References Are Authoritative

The following images are located in the project root:

- `screen.png`
- `screen (2).png`
- `screen (3).png`
- `screen (4).png`
- `screen (5).png`
- `screen (6).png`

These images are the primary visual references for the UI.

The Agent MUST inspect the images before implementing the corresponding pages.

Do not invent a substantially different visual design when the reference already provides the intended layout.

The implementation should reproduce:

- Overall visual hierarchy
- Spacing
- Typography hierarchy
- Navigation structure
- Grid proportions
- Card structure
- Borders
- Color usage
- Buttons
- Metadata placement
- Sidebar positioning
- Tables
- Dashboard cards
- Charts
- Responsive behavior

The screenshots are design references, not pixel-perfect constraints. The implementation should preserve the visual intent while adapting appropriately to responsive web layouts.

---

# 3. DESIGN REFERENCE MAPPING

## 3.1 Public Homepage

Reference:

`screen (4).png`

This represents the primary public homepage.

Important elements:

- Global university navigation
- Main headline/feature article
- 12-column grid
- Supporting news articles
- Trending Research section
- Date chips
- Category labels
- Article metadata
- Structured editorial layout
- Academic/newsroom aesthetic

---

## 3.2 Research & Innovation

Reference:

`screen (5).png`

This represents the Research & Innovation category page.

Important elements:

- Breaking news ticker
- Research-focused article cards
- Category navigation
- Editorial article grid
- Research highlights
- Metadata
- Consistent academic visual hierarchy

---

## 3.3 Single Article

Reference:

`screen (6).png`

This represents the article detail page.

Important elements:

- Article category
- Large article title
- Excerpt
- Author information
- Publication date
- Reading time
- Article content
- Feature image
- Social sharing sidebar
- Category/tag information
- Related articles

---

## 3.4 CMS Article Editor

Reference:

`screen.png`

This represents the admin article editor.

Important elements:

- Dark navy sidebar
- CMS navigation
- Article title input
- Article content editor
- Publishing controls
- Status
- Schedule
- Featured image
- Category
- Tags
- Save draft
- Publish controls

---

## 3.5 CMS Dashboard

Reference:

`screen (2).png`

This represents the admin overview dashboard.

Important elements:

- Total Articles metric
- Total Views metric
- Pending Articles metric
- Authors metric
- Publishing Trends chart
- Recent activity
- Clean administrative layout

---

## 3.6 News Archive

Reference:

`screen (3).png`

This represents the CMS article archive.

Important elements:

- Article table/list
- Search
- Filtering
- Status
- Category
- Author
- Publication date
- Edit action
- View action
- Delete action
- Pagination

---

# 4. TECHNOLOGY STACK

Use the following technologies.

## Backend

- PHP
- Laravel
- Eloquent ORM
- Laravel Routing
- Laravel Validation
- Laravel Policies / Middleware
- Laravel Authentication

Use the latest stable Laravel version compatible with the existing project environment.

Do not perform a major framework upgrade if the project has already been initialized on a specific Laravel major version unless explicitly required.

---

## Frontend

- Laravel Blade
- Tailwind CSS
- Alpine.js
- Vite

Prefer Blade components for reusable UI elements.

Avoid introducing React, Vue, Inertia, Livewire, or other frontend frameworks unless explicitly required later.

---

## Database

- PostgreSQL

Use Laravel migrations for all schema changes.

Never manually depend on an undocumented database schema.

---

# 5. DESIGN SYSTEM

The design should communicate:

> Intellectual, authoritative, editorial, timeless, academic prestige.

Avoid a generic startup dashboard aesthetic.

The visual language should resemble a premium university newsroom / academic publication.

---

# 6. COLOR SYSTEM

Use these colors consistently.

| Purpose           | Color     |
| ----------------- | --------- |
| Primary Navy      | `#00081e` |
| Secondary Crimson | `#b71032` |
| Background        | `#fcf8f9` |
| Surface / Card    | `#ffffff` |
| Main Text         | `#1b1b1c` |
| Border            | `#c5c6cf` |

## Primary Navy — `#00081e`

Use for:

- Main navigation
- Header
- Admin sidebar
- Footer
- Primary branding
- Important dark sections

## Crimson — `#b71032`

Use for:

- Breaking news
- Active states
- Important buttons
- Category highlights
- Date chips
- Editorial emphasis
- Links requiring emphasis

Do not use crimson excessively.

It should function as an editorial accent.

---

# 7. TYPOGRAPHY

Use three primary font families.

## Headlines

**Montserrat**

Use for:

- Headlines
- Large titles
- Section headings
- Dashboard headings

## Body

**Source Serif 4**

Use for:

- Article body
- Long-form editorial content
- Excerpts where appropriate

## Utility

**Work Sans**

Use for:

- Navigation
- Buttons
- Labels
- Tags
- Metadata
- Filters
- Form controls

Typography must create a strong distinction between editorial content and UI controls.

---

# 8. SHAPE AND BORDER SYSTEM

The design must use a sharp editorial aesthetic.

## Border Radius

Default:

```text
0px
```

Use square corners for:

- Cards
- Buttons
- Inputs
- Navigation elements
- Containers
- Tables
- News components

Circular shapes are reserved for:

- User avatars
- Profile images
- Author portraits
- Icon-only profile elements

Do not introduce rounded cards throughout the application.

---

## Borders

Prefer:

```text
1px solid #c5c6cf
```

Use borders to establish hierarchy.

Avoid excessive box shadows.

Use shadows only when they provide a clear functional purpose.

---

# 9. RESPONSIVE DESIGN

The application must work correctly on:

- Desktop
- Laptop
- Tablet
- Mobile

Use Tailwind responsive breakpoints.

The desktop reference images are authoritative for the primary composition, but the layout must adapt naturally on smaller screens.

Examples:

### Desktop

- Multi-column editorial grid
- Sidebar content
- Full navigation
- CMS sidebar

### Tablet

- Reduced column count
- Compressed navigation
- Flexible content widths

### Mobile

- Single-column article layout
- Collapsible navigation
- Stacked dashboard metrics
- Horizontal overflow only where appropriate
- CMS sidebar converted into a mobile navigation mechanism

Never allow the page to overflow horizontally because of fixed desktop widths.

---

# 10. APPLICATION STRUCTURE

Recommended structure:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   └── Public/
│   ├── Requests/
│   └── Middleware/
├── Models/
├── Policies/
└── Providers/

database/
├── migrations/
├── seeders/
└── factories/

resources/
├── css/
├── js/
└── views/
    ├── layouts/
    ├── components/
    ├── public/
    └── admin/

routes/
├── web.php
└── auth.php

storage/
└── app/
    └── public/

tests/
├── Feature/
└── Unit/
```

Adapt this structure to the existing Laravel project rather than blindly creating duplicate structures.

---

# 11. DATABASE DESIGN

Create the database using Laravel migrations.

The primary entities are:

1. Users
2. Categories
3. Articles
4. Tags
5. Article Tags

---

# 12. USERS TABLE

Use Laravel's default users table as the foundation.

Required fields:

```text
id
name
email
password
role
remember_token
created_at
updated_at
```

Role values:

```text
admin
editor
author
```

Default role:

```text
author
```

Do not store plaintext passwords.

Use Laravel's standard password hashing.

---

# 13. CATEGORIES TABLE

Required fields:

```text
id
name
slug
created_at
updated_at
```

Requirements:

- `name` must be unique.
- `slug` must be unique.
- Use Laravel slug generation.
- Category URLs should use the slug.

Example:

```text
research-innovation
campus-life
achievements
student-life
international
events
```

The exact seed categories may be adjusted based on the design references.

---

# 14. ARTICLES TABLE

Required fields:

```text
id
title
slug
excerpt
content
featured_image_path
status
published_at
views_count
user_id
category_id
created_at
updated_at
```

Recommended constraints:

### title

Required.

### slug

Required and unique.

### excerpt

Nullable.

### content

Required.

### featured_image_path

Nullable.

### status

Allowed values:

```text
draft
published
```

### published_at

Nullable timestamp.

### views_count

Integer.

Default:

```text
0
```

### user_id

Foreign key to:

```text
users.id
```

### category_id

Foreign key to:

```text
categories.id
```

Use appropriate foreign key behavior.

Do not allow orphaned article records.

---

# 15. TAGS TABLE

Required fields:

```text
id
name
created_at
updated_at
```

Requirements:

- Tag names should be unique.
- Tags should be reusable between articles.

---

# 16. ARTICLE_TAG PIVOT TABLE

Required fields:

```text
article_id
tag_id
```

Create a composite unique constraint to prevent duplicate relationships.

Relationships:

```text
Article belongsToMany Tag
Tag belongsToMany Article
```

---

# 17. MODEL RELATIONSHIPS

## User

```text
User hasMany Articles
```

## Category

```text
Category hasMany Articles
```

## Article

```text
Article belongsTo User
Article belongsTo Category
Article belongsToMany Tags
```

## Tag

```text
Tag belongsToMany Articles
```

Use Eloquent relationships instead of manually querying foreign keys wherever possible.

---

# 18. AUTHENTICATION

Implement secure authentication for CMS users.

The CMS must not be publicly accessible.

Unauthenticated users attempting to access admin routes must be redirected to login.

Use Laravel's recommended authentication solution compatible with the project.

The authentication UI should follow the overall project design system.

---

# 19. AUTHORIZATION

Implement role-based authorization.

## Admin

Can:

- View dashboard
- Create articles
- Edit all articles
- Delete articles
- Publish articles
- Schedule articles
- Manage categories
- Manage tags
- Manage users
- Manage authors

## Editor

Can:

- View dashboard
- Create articles
- Edit articles
- Edit other authors' articles
- Publish articles
- Manage categories
- Manage tags

## Author

Can:

- View dashboard
- Create articles
- Edit their own articles
- Save drafts
- Upload featured images

Authors must not be able to:

- Delete other authors' articles
- Manage users
- Manage system settings
- Publish restricted content unless explicitly permitted by the application workflow

Use Laravel Policies and/or middleware.

Do not rely only on hidden UI buttons for authorization.

Authorization must be enforced server-side.

---

# 20. PUBLIC ROUTES

Implement routes conceptually similar to:

```text
/
```

Homepage.

```text
/news
```

News archive.

```text
/category/{category:slug}
```

Category page.

```text
/article/{article:slug}
```

Single article.

```text
/research
```

Research & Innovation page.

```text
/search
```

Search results.

The exact route naming may be adapted to Laravel conventions.

---

# 21. ADMIN ROUTES

Use an `/admin` prefix.

Conceptually:

```text
/admin
/admin/articles
/admin/articles/create
/admin/articles/{article}/edit
/admin/categories
/admin/tags
/admin/users
```

Use route groups with authentication middleware.

Apply role authorization where required.

---

# 22. PUBLIC HOMEPAGE REQUIREMENTS

The homepage must be based primarily on:

`screen (4).png`

Implement:

## Header

Include:

- University branding
- Primary navigation
- Search
- Relevant utility links
- Responsive mobile navigation

---

## Breaking / Featured Area

Display the most important editorial content prominently.

The feature article should have:

- Large image
- Category
- Large headline
- Excerpt
- Date
- Author if applicable

---

## Trending Research

Implement a dedicated section based on the screenshot.

Display:

- Ranked/listed research stories
- Article title
- Date
- Category
- Visual date chip where appropriate

---

## Date Chip

Use the visual language from the reference.

Example structure:

```text
┌────┐
│ 16 │
│ AUG│
└────┘
```

Use crimson for the primary date emphasis.

---

# 23. RESEARCH & INNOVATION PAGE

Base the layout on:

`screen (5).png`

Implement:

- Breaking news ticker
- Research category heading
- Research article grid
- Featured research article
- Supporting articles
- Article metadata
- Pagination where necessary

The page should feel editorial rather than like a generic blog listing.

---

# 24. SINGLE ARTICLE PAGE

Base the layout on:

`screen (6).png`

Implement:

## Article Header

Display:

- Category
- Title
- Excerpt
- Author
- Publication date
- Reading time
- Tags

---

## Feature Image

Display a large feature image below or around the article header according to the reference.

Images must be responsive.

---

## Social Sharing

Implement a left-side sharing area on desktop.

Possible actions:

- Copy link
- Facebook
- X/Twitter
- LinkedIn
- Email

On mobile, convert this into a horizontal or compact sharing section.

Do not require external social APIs for basic sharing.

---

## Article Content

Use:

```text
Source Serif 4
```

for long-form article text.

Ensure:

- Good line height
- Comfortable reading width
- Proper heading hierarchy
- Responsive images
- Lists
- Blockquotes
- Links

---

## Related Articles

At the end of the article, show relevant content based on category and/or tags.

---

# 25. CMS DASHBOARD

Base the dashboard on:

`screen (2).png`

Display metrics:

1. Total Articles
2. Total Views
3. Pending/Draft Articles
4. Authors

Use real database values.

Do not hardcode metrics.

---

# 26. PUBLISHING TRENDS

Implement the publishing trends visualization shown in the design.

The chart must use actual article data.

Possible data:

- Articles published per day
- Articles published per week
- Articles published per month

The exact period should be chosen based on the reference design.

Use a lightweight chart solution only if necessary.

Do not introduce a large frontend framework just for the chart.

---

# 27. ARTICLE MANAGEMENT

Base the article archive on:

`screen (3).png`

Implement:

- Search
- Status filter
- Category filter
- Author filter where appropriate
- Sorting
- Pagination

Each article row should provide:

- Title
- Category
- Author
- Status
- Published date
- Views
- Actions

Actions:

```text
View
Edit
Delete
```

Actions must respect authorization.

---

# 28. ARTICLE EDITOR

Base the editor on:

`screen.png`

The editor should contain:

## Main Content Area

- Title
- Slug
- Excerpt
- Article content

## Right Sidebar

- Status
- Publish date
- Schedule
- Featured image
- Category
- Tags

## Actions

```text
Save Draft
Publish
Schedule
```

The interface must clearly distinguish draft and publishing actions.

---

# 29. ARTICLE CONTENT EDITOR

Use a simple maintainable editor.

Do not add a complex third-party editor unless necessary.

The editor must support at minimum:

- Headings
- Paragraphs
- Bold
- Italic
- Links
- Lists
- Blockquotes
- Images

Store article content in a safe format appropriate for rendering.

Never render untrusted HTML without proper sanitization.

---

# 30. FEATURED IMAGE MANAGEMENT

Use Laravel's storage system.

Recommended approach:

```text
storage/app/public/
```

Create appropriate symbolic storage linking.

Images should:

- Be validated
- Have reasonable file size limits
- Have supported MIME types
- Use unique filenames
- Be safely stored
- Be rendered using proper URLs

Do not store uploaded images directly in the database.

Only store their path.

---

# 31. ARTICLE VIEW COUNTER

Implement article view counting.

When a public user opens a published article:

```text
views_count += 1
```

Do not increment views for:

- Draft articles
- Unauthorized preview requests

Avoid accidentally counting internal admin operations as public article views.

---

# 32. SEARCH

Implement article search.

Search should support:

- Article title
- Excerpt
- Relevant content
- Tags
- Categories where appropriate

Use PostgreSQL-compatible queries.

Avoid loading every article into PHP and filtering manually.

---

# 33. ARTICLE STATUS

Articles have two primary states:

```text
draft
published
```

## Draft

- Not publicly visible
- Visible to authorized CMS users
- Can be edited

## Published

- Publicly visible
- Must have a publication timestamp

---

# 34. SCHEDULED PUBLISHING

The CMS should support scheduled publishing through:

```text
published_at
```

Concept:

```text
status = published
published_at <= current time
```

Articles with future publication timestamps must not appear publicly before their scheduled time.

If a scheduler/queue implementation is introduced, use Laravel's native scheduling mechanisms.

---

# 35. PUBLIC ARTICLE QUERY RULES

Public pages must only show articles that are effectively published.

Conceptually:

```text
status = published
AND published_at IS NOT NULL
AND published_at <= now()
```

Do not expose draft or future articles to public visitors.

---

# 36. VALIDATION

Use Laravel Form Request classes where appropriate.

Examples:

## Article

- Title: required
- Slug: required, unique
- Content: required
- Category: required
- Featured image: optional but validated
- Status: restricted to allowed values
- Published date: valid datetime

## Category

- Name: required, unique
- Slug: required, unique

## Tag

- Name: required, unique

Never trust client-side validation alone.

---

# 37. SECURITY REQUIREMENTS

Follow Laravel security best practices.

Requirements:

- CSRF protection
- Password hashing
- Authentication middleware
- Authorization policies
- Server-side validation
- Secure file upload validation
- Safe HTML rendering
- Mass-assignment protection
- No plaintext secrets
- No database credentials in source code

Never commit:

```text
.env
```

or sensitive credentials.

---

# 38. ENVIRONMENT CONFIGURATION

The PostgreSQL connection must be configurable through `.env`.

Example structure:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=news_web
DB_USERNAME=postgres
DB_PASSWORD=
```

Do not hardcode these values in PHP source code.

Do not overwrite an existing working `.env` without inspecting it first.

Update `.env.example` when adding required environment variables.

---

# 39. SEED DATA

Create seeders/factories for development.

Include:

- Admin user
- Editor user
- Author user
- Several categories
- Several tags
- Several articles
- Published articles
- Draft articles
- Different publication dates
- Sample article views

Seed data must demonstrate the actual UI.

Do not use meaningless placeholder content such as:

```text
Lorem ipsum
Test article
ABC
123
```

Use realistic university news content.

---

# 40. BLADE ARCHITECTURE

Use reusable Blade components.

Examples:

```text
resources/views/components/
├── article-card.blade.php
├── article-meta.blade.php
├── category-badge.blade.php
├── date-chip.blade.php
├── featured-article.blade.php
├── breaking-news.blade.php
├── pagination.blade.php
└── ...
```

Only create components when they improve reuse and maintainability.

Avoid excessive fragmentation.

---

# 41. LAYOUT ARCHITECTURE

Create separate layouts where appropriate.

Example:

```text
resources/views/layouts/
├── app.blade.php
├── public.blade.php
└── admin.blade.php
```

Public pages should not depend on the admin layout.

Admin pages should share the CMS navigation structure.

---

# 42. TAILWIND IMPLEMENTATION

Configure the design tokens in the project's Tailwind setup.

Do not repeatedly hardcode the same colors throughout templates when reusable theme values can be defined.

The following values are mandatory:

```text
Primary Navy: #00081e
Crimson: #b71032
Background: #fcf8f9
Surface: #ffffff
Text: #1b1b1c
Border: #c5c6cf
```

Use Tailwind utility classes consistently.

Avoid creating unnecessary custom CSS when Tailwind can solve the problem cleanly.

---

# 43. ACCESSIBILITY

Implement reasonable accessibility.

Requirements:

- Semantic HTML
- Proper heading hierarchy
- Accessible form labels
- Keyboard navigation
- Visible focus states
- Alt text for meaningful images
- Accessible buttons
- Adequate contrast
- Descriptive links

Do not use color as the only indicator of status.

---

# 44. PERFORMANCE

Prefer:

- Eager loading where appropriate
- Pagination
- Efficient queries
- Image optimization
- Laravel caching where beneficial
- Database indexes on frequently queried fields

Recommended indexes:

```text
articles.slug
articles.status
articles.published_at
articles.category_id
articles.user_id
categories.slug
tags.name
```

Do not optimize prematurely, but avoid obvious N+1 queries.

---

# 45. SEO

Public article pages should include:

- Meaningful `<title>`
- Meta description
- Canonical URL
- Open Graph metadata
- Article metadata where appropriate
- Semantic HTML

Article URLs should use slugs.

Example:

```text
/article/university-launches-new-ai-research-center
```

---

# 46. ERROR HANDLING

Implement proper handling for:

- 404
- Unauthorized access
- Validation errors
- Missing articles
- Missing categories
- Invalid uploads

Do not expose stack traces or sensitive configuration in production.

---

# 47. TESTING

Create Feature/Unit tests for important functionality.

At minimum test:

## Authentication

- Guest cannot access admin pages.
- Authenticated users can access authorized CMS pages.

## Authorization

- Admin permissions work.
- Editor permissions work.
- Author permissions work.
- Authors cannot modify unauthorized articles.

## Articles

- Article creation works.
- Article editing works.
- Drafts are not publicly visible.
- Published articles are publicly visible.
- Future articles are not publicly visible.
- Article slug works.
- View counter works.

## Categories and Tags

- Category creation works.
- Tag creation works.
- Article relationships work.

---

# 48. DEVELOPMENT WORKFLOW

The Agent MUST implement the project incrementally.

Do not attempt to generate the entire application in one uncontrolled operation.

Follow this order.

---

## PHASE 1 — PROJECT AUDIT

Before modifying anything:

1. Inspect repository.
2. Identify Laravel version.
3. Identify PHP version.
4. Identify Node/npm version.
5. Inspect Composer dependencies.
6. Inspect NPM dependencies.
7. Inspect database configuration.
8. Inspect existing application code.
9. Inspect all six reference images.

Do not make destructive changes during this phase.

---

## PHASE 2 — FOUNDATION

Implement:

- Laravel configuration
- PostgreSQL connection
- Tailwind
- Vite
- Alpine.js
- Fonts
- Design tokens
- Base layouts
- Basic application navigation

Then verify the application starts.

---

## PHASE 3 — DATABASE

Implement:

- Users
- Categories
- Articles
- Tags
- Article_Tag

Then:

1. Run migrations.
2. Verify PostgreSQL schema.
3. Create factories.
4. Create seeders.
5. Seed development data.

Fix all migration errors before continuing.

---

## PHASE 4 — AUTHENTICATION & AUTHORIZATION

Implement:

- Login
- Logout
- Admin middleware
- Roles
- Policies
- User authorization

Verify all roles before building CMS CRUD.

---

## PHASE 5 — PUBLIC WEBSITE

Implement in this order:

1. Public layout
2. Header
3. Footer
4. Homepage
5. Category page
6. Research page
7. Article detail
8. Search
9. Related articles
10. Responsive behavior

Compare every major page with the corresponding reference screenshot.

---

## PHASE 6 — CMS

Implement:

1. Admin layout
2. Dashboard
3. Article archive
4. Article creation
5. Article editor
6. Article editing
7. Categories
8. Tags
9. User management
10. Publishing workflow

---

## PHASE 7 — POLISH

After core functionality works:

- Responsive refinement
- Typography refinement
- Spacing refinement
- Accessibility
- SEO
- Loading states
- Empty states
- Error states
- Form validation UX
- Image handling
- Performance improvements

---

## PHASE 8 — TESTING

Run:

```bash
php artisan test
```

Also run:

```bash
php artisan migrate:fresh --seed
```

in the development environment when appropriate.

Run frontend build:

```bash
npm run build
```

Fix all errors before declaring implementation complete.

---

# 49. AGENT EXECUTION RULES

When implementing a task:

1. Explain briefly what will be changed.
2. Inspect relevant existing files.
3. Make the smallest coherent set of changes.
4. Run relevant commands.
5. Inspect the result.
6. Fix errors.
7. Continue to the next phase only when the current phase is functional.

Do not:

- Delete unrelated files.
- Replace the entire project unnecessarily.
- Rewrite working code without reason.
- Introduce unnecessary dependencies.
- Ignore migration errors.
- Ignore browser/UI errors.
- Hardcode database records in controllers.
- Hardcode credentials.
- Bypass authorization.
- Ignore the provided design screenshots.

---

# 50. DEPENDENCY POLICY

Before installing a new package, determine whether the functionality can be implemented using:

- Laravel
- Blade
- Tailwind
- Alpine.js
- Native browser APIs

Only install additional dependencies when there is a clear technical reason.

When a package is required:

1. Explain why.
2. Prefer well-maintained packages.
3. Avoid redundant packages.
4. Verify compatibility with the Laravel/PHP version.

---

# 51. COMMAND EXECUTION POLICY

The Agent may execute development commands when necessary.

Examples:

```bash
composer install
npm install
php artisan migrate
php artisan db:seed
php artisan storage:link
npm run build
php artisan test
```

Before running destructive commands such as:

```bash
php artisan migrate:fresh
```

verify that the environment is a development environment and that no important production data will be destroyed.

Never execute destructive production operations automatically.

---

# 52. FILE MODIFICATION POLICY

Before modifying a file:

- Read it first.
- Understand its current role.
- Preserve useful existing functionality.

If a file already contains a correct implementation, modify only what is necessary.

Avoid unnecessary rewrites.

---

# 53. DESIGN QUALITY CHECKLIST

Before considering a page complete, verify:

- [ ] Correct colors
- [ ] Correct typography
- [ ] Correct spacing
- [ ] Correct borders
- [ ] Sharp 0px corners where required
- [ ] Correct editorial hierarchy
- [ ] Correct image proportions
- [ ] Correct navigation
- [ ] Correct metadata
- [ ] Correct responsive behavior
- [ ] No horizontal overflow
- [ ] No broken images
- [ ] No console errors
- [ ] No obvious accessibility problems

---

# 54. FUNCTIONAL ACCEPTANCE CRITERIA

The project is considered functionally complete when:

## Public Website

- [ ] Homepage loads successfully.
- [ ] Homepage follows `screen (4).png`.
- [ ] Research page follows `screen (5).png`.
- [ ] Article page follows `screen (6).png`.
- [ ] Navigation works.
- [ ] Category pages work.
- [ ] Search works.
- [ ] Articles display correctly.
- [ ] Draft articles are hidden.
- [ ] Future articles are hidden.
- [ ] Published articles are accessible.
- [ ] Article views are counted.
- [ ] Related articles work.
- [ ] Responsive layouts work.

## CMS

- [ ] Login works.
- [ ] Dashboard loads.
- [ ] Dashboard metrics use real database data.
- [ ] Publishing trends use real data.
- [ ] Article archive works.
- [ ] Search works.
- [ ] Filtering works.
- [ ] Pagination works.
- [ ] Create article works.
- [ ] Edit article works.
- [ ] Delete article works where authorized.
- [ ] Draft workflow works.
- [ ] Publishing works.
- [ ] Scheduling works.
- [ ] Featured image upload works.
- [ ] Categories work.
- [ ] Tags work.
- [ ] Role authorization works.

---

# 55. VISUAL ACCEPTANCE CRITERIA

The implementation must visually resemble the provided reference images.

Priority order:

1. Layout structure
2. Typography hierarchy
3. Color system
4. Spacing
5. Component structure
6. Images
7. Borders
8. Responsive behavior
9. Minor visual details

Do not sacrifice functionality to achieve pixel-perfect visual reproduction.

If the reference image contains a visual pattern that cannot be reproduced exactly with the current stack, reproduce the closest maintainable implementation.

---

# 56. DEFINITION OF DONE

The project is NOT considered complete merely because the application compiles.

The project is complete only when:

- Laravel starts successfully.
- PostgreSQL connection works.
- Migrations work.
- Seeders work.
- Authentication works.
- Authorization works.
- Public pages work.
- CMS pages work.
- CRUD works.
- Publishing workflow works.
- Image uploads work.
- Search works.
- Responsive UI works.
- Tests pass.
- Production build succeeds.
- No major browser console errors remain.
- UI has been compared against the provided screenshots.

---

# 57. FINAL VERIFICATION COMMANDS

Before completion, verify:

```bash
php artisan about
```

```bash
php artisan migrate:status
```

```bash
php artisan route:list
```

```bash
php artisan test
```

```bash
npm run build
```

If appropriate for the development environment:

```bash
php artisan migrate:fresh --seed
```

Then start the application and manually verify the main pages.

---

# 58. AGENT FINAL REPORT

After completing implementation, provide a concise final report containing:

## Implemented

List the major features implemented.

## Database

List the migrations/models created.

## Authentication

Explain the roles and authorization implemented.

## Public Pages

List implemented public routes/pages.

## CMS

List implemented admin features.

## Testing

Report commands executed and their results.

## Remaining Issues

Explicitly list anything that could not be completed.

Do not claim a feature is complete if it was not actually tested.

---

# 59. CURRENT PROJECT CONTEXT

The project is being developed using:

```text
IDE: Antigravity IDE
Project Folder: News_Web
Database: PostgreSQL
Backend: Laravel
Frontend: Blade + Tailwind CSS + Alpine.js
Build Tool: Vite
```

The project currently contains the following design references in the project root:

```text
DESIGN.md
screen.png
screen (2).png
screen (3).png
screen (4).png
screen (5).png
screen (6).png
```

These files must be treated as available project assets.

---

# 60. START HERE

When this specification is first provided to the Agent:

### Step 1

Inspect the entire existing project.

### Step 2

Inspect all six design reference images.

### Step 3

Determine the current Laravel/project state.

### Step 4

Create an implementation plan based on the phases in this document.

### Step 5

Do not immediately generate the entire application.

Start with **PHASE 1 — PROJECT AUDIT**.

After the audit, proceed to **PHASE 2 — FOUNDATION**.

Continue sequentially until the acceptance criteria are satisfied.

The Agent should prioritize:

> **Correctness → Security → Functionality → Design Fidelity → Performance → Polish**

Do not skip foundational steps merely to produce a visually complete frontend quickly.

---

# END OF PROJECT SPECIFICATION
