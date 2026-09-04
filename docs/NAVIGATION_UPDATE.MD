# AGENT TASK: MINOR PUBLIC NAVIGATION & HOMEPAGE UI UPDATE

You are working inside an EXISTING and FUNCTIONING Laravel University News Portal project.

This is a SMALL CLIENT REQUEST.

Your responsibility is to make ONLY the requested navigation and homepage text changes while preserving all existing functionality and architecture.

============================================================ 0. CRITICAL RULE — DO NOT START CODING IMMEDIATELY
============================================================

Before modifying any file:

1. Inspect the current project structure.
2. Identify the existing public layout/header/navigation component.
3. Identify the existing homepage Blade view.
4. Identify the existing Category model and database structure.
5. Identify existing category routes.
6. Identify how categories are currently passed to public views/layouts.
7. Identify existing active-navigation logic.
8. Identify whether Alpine.js is already installed/configured.
9. Inspect the current header visually if a screenshot/reference is available.
10. Determine the MINIMUM number of files that need modification.

Do NOT create or modify files before completing this inspection.

After inspection, briefly report:

- Header/navigation file found
- Homepage file found
- Category data source
- Category route
- Existing active-state mechanism
- Alpine.js availability
- Files that will be modified
- Any potential issue

Then proceed with the implementation.

Do NOT ask me for information that can be discovered by inspecting the project.

============================================================

1. # PROJECT CONTEXT

The existing public header currently contains navigation similar to:

- Home
- Research & Innovation
- Campus Life
- Achievements
- Search
- Staff Login

The client wants the top-level navigation reduced to exactly THREE primary navigation items:

1. Home
2. News & Event
3. Achievements

The final navigation should conceptually be:

Home | News & Event | Achievements | Search | Staff Login

The existing visual design must be preserved as much as possible.

This is NOT a request to redesign the entire header.

============================================================ 2. VISUAL REFERENCE
============================================================

A screenshot of the current public header may be available in the project or attached to this task.

If a screenshot/reference image is available:

- Inspect it before modifying the header.
- Use it as the visual baseline.
- Preserve the current header proportions.
- Preserve logo placement.
- Preserve search placement.
- Preserve Staff Login placement.
- Preserve navigation spacing.
- Preserve typography.
- Preserve active-state styling.
- Preserve the overall visual hierarchy.

If the screenshot is not physically available to the Agent, do NOT stop the task.

Instead, inspect the existing implementation and preserve the current UI visually.

IMPORTANT:

Do not redesign the header from scratch.

============================================================ 3. REQUIRED TOP-LEVEL NAVIGATION
============================================================

Replace the existing primary navigation links with EXACTLY:

- Home
- News & Event
- Achievements

Remove these as standalone top-level navigation items:

- Research & Innovation
- Campus Life

Do NOT leave duplicate links elsewhere in the primary navigation.

Research & Innovation and Campus Life MAY appear inside the News & Event dropdown IF they exist as actual categories in the project.

The final primary navigation must contain exactly three main navigation items.

Search and Staff Login are separate utility elements and should remain.

============================================================ 4. NEWS & EVENT DROPDOWN
============================================================

Transform "News & Event" into a category dropdown.

The dropdown must support:

DESKTOP:

- Hover to open
- Click to toggle
- Mouse movement away should allow it to close appropriately

MOBILE / TOUCH:

- Tap/click to open and close
- Do NOT rely only on CSS hover

KEYBOARD:

- The trigger should be keyboard accessible.
- Use appropriate accessibility attributes.
- Where practical, allow keyboard users to open/close the menu.

Preferred implementation:

- Use Alpine.js IF Alpine.js is already available in the project.
- Do NOT introduce a new JavaScript framework.
- Do NOT add unnecessary dependencies.

The interaction should feel lightweight and natural.

============================================================ 5. DROPDOWN IMPLEMENTATION
============================================================

The dropdown should be anchored directly beneath "News & Event".

Conceptually:

    News & Event
         ↓
    ┌──────────────────────┐
    │ Category 1           │
    │ Category 2           │
    │ Category 3           │
    │ ...                  │
    └──────────────────────┘

Requirements:

- No layout shifting.
- Dropdown should appear above other page content.
- Use appropriate z-index.
- Dropdown should not be clipped by the header.
- Dropdown should close when appropriate.
- Avoid excessive animation.
- If a transition is used, keep it subtle.

Accessibility:

The News & Event trigger should use appropriate attributes such as:

aria-haspopup="true"

aria-expanded="..."

Do not rely exclusively on color or hover state to communicate interaction.

============================================================ 6. DROPDOWN VISUAL DESIGN
============================================================

Follow the existing project design system.

Primary Navy:

#00081e

Crimson:

#b71032

Surface:

#ffffff

Border:

#c5c6cf

Dropdown requirements:

- White background
- 1px border using #c5c6cf
- 0px border radius
- Navy text
- Crimson hover/active emphasis
- No heavy shadow
- Editorial/newspaper aesthetic
- Consistent spacing with the existing navigation

Do not introduce rounded cards or excessive modern UI styling.

The dropdown must visually belong to the existing header.

============================================================ 7. CATEGORY DATA — IMPORTANT
============================================================

Before creating dropdown items, inspect how categories currently work.

PRIORITY 1:

If `$categories` is already available from a controller, view composer, shared view, layout, or other existing mechanism:

USE IT.

Do not replace it.

PRIORITY 2:

If categories exist through an existing Category model/database relationship but are not currently available in the header:

Reuse the existing Category model and existing query/data mechanism.

Do NOT create another category model.

Do NOT create duplicate database tables.

PRIORITY 3:

Only if the existing project genuinely has no category data available:

Use a temporary fallback structure.

Example:

- Campus Life
- Research
- Announcements

However:

- Keep fallback data in ONE clear location.
- Do not hardcode category names into multiple Blade files.
- Structure it so it can easily be replaced with database data later.

If the database already contains categories, NEVER use the fallback instead.

============================================================ 8. CATEGORY ROUTES — IMPORTANT
============================================================

Before generating category links:

INSPECT EXISTING ROUTES.

Search:

- routes/web.php
- route names
- category controllers
- category views
- existing article/news URLs

Reuse the existing category route whenever possible.

Do NOT invent a new route if one already exists.

For example, if the project already has a named route such as:

category.show

use it.

If the project already has a route such as:

/news/category/{slug}

reuse it.

Use category slugs where appropriate.

Do NOT create duplicate category routes.

Do NOT create duplicate controllers.

Do NOT create duplicate category pages.

============================================================ 9. ACTIVE NAVIGATION STATE
============================================================

Preserve the existing active navigation styling.

The current design uses a Crimson/red active indicator such as an underline.

Expected behavior:

HOME:

- Active on the homepage.

NEWS & EVENT:

- Active when the user is on relevant news/category/article pages, according to the existing routing structure.

ACHIEVEMENTS:

- Active on achievements-related pages if such a route/page exists.

Do NOT rewrite the active-state system unnecessarily.

If the project already has a reusable Blade component/helper for active navigation:

REUSE IT.

The active styling should remain visually consistent with the existing header.

============================================================ 10. SEARCH
============================================================

Do NOT modify existing search functionality.

Preserve:

- Search input
- Search route
- Search behavior
- Search styling
- Search placement

Only adjust spacing if necessary because the primary navigation now contains fewer items.

Do not redesign search.

============================================================ 11. STAFF LOGIN
============================================================

Do NOT modify authentication logic.

Preserve:

- Staff Login link
- Existing authentication route
- Existing visual styling
- Existing position

Do not create a new authentication system.

Do not modify Login, Register, Password Reset, or CMS authentication as part of this task.

============================================================ 12. HOMEPAGE TEXT UPDATE
============================================================

Find the homepage section currently titled:

"Trending Research"

Change ONLY the displayed text to:

"Trending Search"

This text change must be EXACT.

Do NOT change:

- Typography classes
- Font size
- Font weight
- Colors
- Spacing
- Grid
- Cards
- Images
- Article queries
- Section layout
- Responsive behavior

This is a TEXT-ONLY change.

============================================================ 13. DESIGN SYSTEM
============================================================

Follow the project's existing DESIGN.md specification.

Use:

Primary Navy:
#00081e

Crimson:
#b71032

Background:
#fcf8f9

Surface:
#ffffff

Text:
#1b1b1c

Border:
#c5c6cf

Typography:

Navigation / utility:
Work Sans

Headings:
Montserrat

Body:
Source Serif 4 where already applicable

Maintain the existing design system.

Do not globally change fonts or Tailwind configuration for this task.

============================================================ 14. FILE SCOPE
============================================================

Likely files may include:

resources/views/layouts/public.blade.php

OR:

resources/views/components/header.blade.php

OR another existing navigation component.

The homepage may be:

resources/views/home.blade.php

OR another existing homepage view.

DO NOT assume filenames.

Inspect the project first.

Only modify files that are actually necessary.

Possible files:

- Existing public layout/header Blade
- Existing homepage Blade
- Existing category data/view composer file ONLY if necessary
- Existing navigation component ONLY if necessary

Do NOT modify unrelated files.

============================================================ 15. DO NOT DO THESE THINGS
============================================================

This is a minor client revision.

DO NOT:

- Rebuild Laravel
- Reinitialize Laravel
- Replace the existing frontend architecture
- Replace Alpine.js
- Install React
- Install Vue
- Install jQuery
- Install unnecessary packages
- Rewrite the database
- Create duplicate categories
- Create duplicate routes
- Create duplicate controllers
- Redesign the homepage
- Redesign the entire header
- Change the logo
- Change the color palette
- Change global typography
- Modify authentication
- Modify CMS functionality
- Modify article creation logic
- Modify article database structure
- Modify search backend
- Modify unrelated pages

Prefer minimal, targeted changes.

============================================================ 16. RESPONSIVE REQUIREMENTS
============================================================

Desktop:

The navigation should remain approximately:

Home | News & Event | Achievements | Search | Staff Login

News & Event should open its category dropdown.

Mobile/tablet:

- Navigation must remain usable.
- News & Event must be accessible through tap/click.
- Do not rely exclusively on hover.
- Dropdown must fit inside the viewport.
- No horizontal overflow.
- Do not break the existing mobile navigation if one exists.

If the project already has a mobile navigation system:

REUSE IT.

Do not create a second competing mobile navigation system.

============================================================ 17. ACCESSIBILITY
============================================================

Ensure:

- Navigation links are semantic.
- Dropdown trigger is keyboard accessible.
- Dropdown state is communicated through aria-expanded.
- Dropdown relationship uses aria-haspopup where appropriate.
- Focus states remain visible.
- Interactive elements are actual buttons/links rather than clickable divs where appropriate.

Do not sacrifice accessibility for the hover effect.

============================================================ 18. IMPLEMENTATION PROCESS
============================================================

Follow this exact process:

STEP 1 — AUDIT

Inspect:

- Header/navigation
- Homepage
- Routes
- Category model
- Category data
- Active navigation logic
- Alpine.js setup

STEP 2 — PLAN

Determine:

- Exact files to modify
- Existing category source
- Existing category route
- Best dropdown implementation

STEP 3 — IMPLEMENT

Make only the necessary changes.

STEP 4 — REVIEW

Inspect the modified files for:

- Blade syntax errors
- Incorrect routes
- Undefined variables
- Duplicate links
- Broken Alpine.js directives
- Incorrect Tailwind classes
- Accessibility issues

STEP 5 — TEST

Verify the navigation and homepage.

============================================================ 19. TESTING CHECKLIST
============================================================

Navigation:

[ ] Exactly 3 top-level navigation items:
[ ] Home
[ ] News & Event
[ ] Achievements

[ ] Research & Innovation removed from top level.
[ ] Campus Life removed from top level.
[ ] Search still works.
[ ] Staff Login still works.

Dropdown:

[ ] Opens on desktop hover.
[ ] Opens/closes on click.
[ ] Works on touch/mobile.
[ ] Does not rely exclusively on hover.
[ ] Uses existing categories.
[ ] Uses existing category routes.
[ ] Does not create duplicate category logic.
[ ] White background.
[ ] 1px border.
[ ] 0px border radius.
[ ] Navy text.
[ ] Crimson hover/active styling.
[ ] No excessive shadow.
[ ] Does not cause layout shift.
[ ] Does not get clipped.
[ ] Has appropriate z-index.
[ ] Keyboard accessible.
[ ] aria-expanded works correctly.

Active state:

[ ] Home active state works.
[ ] News & Event active state works.
[ ] Achievements active state works.
[ ] Existing Crimson underline is preserved.

Homepage:

[ ] "Trending Research" changed to exactly "Trending Search".
[ ] No other section structure changed.
[ ] Existing typography preserved.

Regression:

[ ] Homepage loads.
[ ] News pages load.
[ ] Category pages load.
[ ] Article pages load.
[ ] Search works.
[ ] Staff Login works.
[ ] No JavaScript console errors.
[ ] No Blade errors.
[ ] No broken links.
[ ] No horizontal overflow.
[ ] No unrelated functionality changed.

============================================================ 20. OPTIONAL VERIFICATION COMMANDS
============================================================

Use appropriate existing project commands.

For example:

php artisan route:list

npm run build

php artisan test

Do NOT run destructive commands.

NEVER run:

php artisan migrate:fresh

Do not reset or delete the database.

If the project has no test suite, do not fabricate test results.

============================================================ 21. FINAL REPORT
============================================================

After implementation, provide a concise final report containing:

1. Header/navigation file modified
2. Homepage file modified
3. Category data source used
4. Category route reused
5. Dropdown implementation
6. Whether Alpine.js was used
7. Files changed
8. Tests/verification performed
9. Any issues discovered
10. Confirmation that unrelated functionality was preserved

Also explicitly state:

- Whether the client request was fully implemented.
- Whether any part remains incomplete.
- Any future configuration that may be required.

Do not claim something was tested if it was not actually tested.

============================================================ 22. FINAL PRINCIPLE
============================================================

This is an EXISTING PROJECT.

The correct approach is:

AUDIT
→ REUSE
→ MODIFY MINIMALLY
→ VERIFY

NOT:

REBUILD
→ REFACTOR
→ REPLACE

Preserve the existing architecture and functionality at all costs unless a change is directly required by this specification.
