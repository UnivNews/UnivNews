# University News Portal — Authentication & Onboarding Specification

> **Document Type:** Supplemental AI Coding Agent Specification
> **Project:** University News Portal
> **Scope:** Authentication & Onboarding UI
> **Primary IDE:** Antigravity IDE
> **Backend:** Laravel
> **Frontend:** Blade + Tailwind CSS + Alpine.js
> **Database:** PostgreSQL
> **Status:** Agent-Ready
> **Relationship:** Supplemental specification to `DESIGN.md`

---

# 1. PURPOSE

This document is a supplemental specification to the main project specification in `DESIGN.md`.

The core University News Portal application has already been implemented and is functioning.

This document focuses specifically on completing and refining the following authentication and onboarding flows:

1. Login
2. Account Request
3. Forgot Password
4. Password Reset Link Sent
5. Create New Password

The primary objective is to make these authentication pages visually consistent with the provided design references while preserving all existing authentication functionality.

---

# 2. CRITICAL PROJECT CONTEXT

The existing University News Portal is already functional.

The Agent MUST treat the current project as an existing application, NOT as a new Laravel project.

The Agent MUST NOT:

- Reinitialize Laravel.
- Replace the existing authentication system.
- Replace working authentication routes.
- Replace working controllers.
- Replace working middleware.
- Replace working password reset logic.
- Replace the existing database structure unnecessarily.
- Rewrite unrelated public portal pages.
- Rewrite the CMS.
- Remove existing functionality without a clear requirement.

The primary scope is the authentication UI.

Existing backend authentication logic must be preserved whenever possible.

---

# 3. DESIGN REFERENCE LOCATION

All authentication design references are located inside:

```text
design_references/
```

The Agent MUST inspect this directory before implementing the authentication pages.

Important:

> File extensions may be `.png` or `.jpg`. Do not assume an extension. Inspect the actual files present in the directory.

Authentication references:

```text
screen (7)  → Password Reset Link Sent
screen (8)  → Forgot Password
screen (9)  → Login
screen (10) → Account Request
screen (11) → Create New Password
```

The Agent MUST inspect the actual files and confirm their filenames/extensions before implementation.

Do not rely exclusively on the descriptions in this document when the visual reference is available.

The screenshots are the primary visual source of truth for layout and appearance.

---

# 4. RELATIONSHIP WITH DESIGN.md

`DESIGN.md` remains the primary project-wide design specification.

This document extends `DESIGN.md` specifically for authentication.

If a design rule appears in both documents, the authentication-specific rule in this document applies to authentication pages.

The Agent MUST preserve the project's established:

- Color palette
- Typography
- Border system
- Editorial visual language
- Accessibility standards
- Responsive behavior

---

# 5. AUTHENTICATION DESIGN SYSTEM

Authentication pages intentionally use a simpler centered-card composition than the public news portal.

## Background

Use:

```text
#fcf8f9
```

as the primary page background.

---

## Card

Use:

```text
#ffffff
```

for the main authentication card.

Use a subtle:

```text
1px solid #c5c6cf
```

border where appropriate.

---

## Border Radius

Strictly use:

```text
0px
```

for:

- Authentication cards
- Inputs
- Buttons
- Selects
- Alerts
- Structural containers

Do NOT use:

- `rounded`
- `rounded-md`
- `rounded-lg`
- `rounded-xl`
- `rounded-full`

on structural UI elements.

Circular shapes are permitted only for:

- Graduation cap icon container
- Email/checkmark icon container
- User avatars
- Profile imagery

---

# 6. AUTHENTICATION TYPOGRAPHY

## Headings

Use:

```text
Montserrat
```

for:

- Login heading
- Account Request heading
- Reset Password heading
- Link Sent heading
- Create New Password heading

---

## Labels and Buttons

Use:

```text
Work Sans
```

for:

- Form labels
- Buttons
- Navigation links
- Checkbox labels
- Utility text
- Tags

---

## Article/Editorial Typography

Authentication pages generally do not require the Source Serif 4 editorial font.

Use `Source Serif 4` only where supporting body copy benefits from the project's editorial style.

---

# 7. COLOR TOKENS

Use the established project colors:

```text
Primary Navy: #00081e
Crimson:     #b71032
Background:  #fcf8f9
Surface:     #ffffff
Text:        #1b1b1c
Border:      #c5c6cf
```

## Navy

Primary use:

- Sign In button
- Request Access button
- Send Reset Link button
- Reset Password button
- Open Email App button
- Important headings where appropriate

## Crimson

Primary use:

- Password reset emphasis
- Active links
- Warning notices
- Error states
- Security notices
- Icon accents
- Top border accents
- Return-to-login links

---

# 8. EXISTING AUTHENTICATION ARCHITECTURE

Before changing anything, the Agent MUST inspect the existing authentication implementation.

Determine whether the project uses:

- Laravel Breeze
- Laravel Fortify
- Laravel Jetstream
- Laravel's custom authentication
- Another existing authentication implementation

Inspect at minimum:

```text
routes/
app/Http/Controllers/
app/Http/Requests/
app/Models/
resources/views/auth/
resources/views/layouts/
resources/views/components/
database/migrations/
```

Also inspect:

```text
composer.json
package.json
```

and relevant authentication configuration.

The Agent MUST report which authentication system is currently being used before making authentication changes.

---

# 9. AUTHENTICATION MODIFICATION RULE

The Agent MUST preserve existing authentication logic.

The primary modification target is:

```text
resources/views/auth/
```

and related authentication layout/component files.

However, if a backend change is absolutely necessary for the requested UI to function, the Agent may modify the relevant backend implementation.

Any backend modification must:

1. Be minimal.
2. Preserve existing behavior.
3. Be compatible with the current Laravel version.
4. Not replace the authentication architecture.
5. Be tested after modification.

Do NOT replace working authentication functionality merely to match the screenshot.

---

# 10. AUTHENTICATION ROUTE POLICY

The following routes represent the expected conceptual authentication flow:

```text
GET  /login
POST /login

POST /logout

GET  /forgot-password
POST /forgot-password

GET  /reset-password/{token}
POST /reset-password

GET  /account-request
POST /account-request
```

These are conceptual routes.

The Agent MUST inspect the existing route definitions first.

If the current application already has equivalent routes, preserve them.

Do not create duplicate authentication routes.

---

# 11. LOGIN PAGE

## Reference

Inspect:

```text
design_references/screen (9).jpg
```

or the actual corresponding file extension.

---

## Layout

Use:

- Full-height page
- Background `#fcf8f9`
- Centered authentication card
- Responsive width
- Appropriate desktop spacing
- Near-full-width card on mobile with safe horizontal padding

---

## Required Elements

### Graduation Cap

Place a circular graduation cap icon at the top of the authentication card.

The circular container may use:

```text
border-radius: 9999px
```

because this is an explicitly permitted circular icon element.

---

### Login Heading

Use the heading and supporting text shown in the reference.

Do not invent additional institutional claims.

---

### Email / NetID

Display the field label as:

```text
Email Address / NetID
```

Include a user/person icon.

IMPORTANT:

The visual label must not automatically imply that the backend authentication identifier has been changed.

The Agent MUST preserve the existing login identifier.

If the existing authentication system uses email, continue using email.

Do not modify the database to introduce NetID unless explicitly required.

---

### Password

Include:

- Password label
- Password input
- Visibility toggle
- Eye icon
- Forgot Password link

The visibility toggle MUST be implemented using Alpine.js.

---

### Remember Me

Display:

```text
Keep me signed in for 30 days
```

Use the existing Laravel remember-me functionality.

Do NOT replace the existing session/authentication system solely to implement the wording "30 days".

If the existing system has configurable remember duration, use the appropriate existing mechanism.

---

### Sign In

Primary button:

```text
Sign In
```

Use:

```text
#00081e
```

The button must submit the existing authentication form.

Do not replace the existing authentication endpoint.

---

### Divider

Display:

```text
OR
```

with an appropriate horizontal divider.

---

### Institutional SSO

Display a secondary outlined button:

```text
Institutional SSO
```

with a red/crimson icon according to the reference.

IMPORTANT:

No actual SSO provider currently exists.

Therefore:

- Do NOT invent an SSO provider.
- Do NOT invent an SSO URL.
- Do NOT add fake credentials.
- Do NOT integrate with Google, Microsoft, Okta, Azure AD, or another provider without explicit instruction.

For now, implement the button as a clearly identifiable placeholder action.

If appropriate, it may be disabled or display a non-destructive "SSO is not configured yet" state.

The visual appearance must remain faithful to the screenshot.

---

### Footer

Include:

- Privacy Policy
- Terms of Service
- Copyright

Because this is currently a personal/independent project:

Do not invent legal text.

If dedicated legal pages do not exist, use placeholder links that can later be configured.

Copyright information should be configurable rather than hardcoded to an invented institution.

---

# 12. ACCOUNT REQUEST PAGE

## Reference

Inspect:

```text
design_references/screen (10).jpg
```

or the actual corresponding extension.

---

## Purpose

The university/project does NOT use open public registration.

Instead, faculty/staff access is requested through an Account Request flow.

Therefore:

> Public registration must not be presented as the normal authentication flow.

---

## Required Fields

### Full Name

Required.

---

### Institutional Email

Required.

Validate as an email address.

Do not automatically restrict the domain unless an institutional domain is already configured in the project.

Do not invent an institutional domain.

---

### Department / Role

Use a dropdown/select.

The Agent MUST inspect whether department or role data already exists in the project.

If no data exists:

- Do not invent a large university department list.
- Keep the options configurable.
- Use a small temporary set only if required by the design.
- Make it easy to replace later.

---

## Request Access Button

Display:

```text
Request Access
```

Use Navy:

```text
#00081e
```

The form must use proper server-side validation.

---

# 13. ACCOUNT REQUEST BACKEND POLICY

The Agent MUST first determine whether an account request backend already exists.

If it exists:

- Reuse it.
- Do not replace it.
- Connect the new UI to the existing flow.

If it does NOT exist:

The Agent must determine whether the current task is intended to be UI-only.

Do NOT silently create a complex account approval system without confirming that the existing project architecture requires it.

If a backend implementation is required, use a dedicated model/table rather than modifying the `users` table to represent pending requests.

A potential future structure is:

```text
account_requests
----------------
id
full_name
institutional_email
department_role
status
reviewed_by
reviewed_at
created_at
updated_at
```

Potential statuses:

```text
pending
approved
rejected
```

This structure is a future-compatible recommendation, not a requirement to implement a full approval workflow unless required by the current project.

---

# 14. ACCOUNT REQUEST SUCCESS STATE

After successful submission, provide a clear confirmation state.

Do not invent email addresses, phone numbers, or institutional contact information.

Example configurable message:

```text
Your account request has been submitted successfully.
```

The exact final copy should follow the reference design where applicable.

---

# 15. RETURN TO LOGIN

Display:

```text
Already verified? Return to login.
```

Use Crimson:

```text
#b71032
```

The link MUST point to the existing login route.

---

# 16. SECURITY NOTICE

The bottom warning notice must have a Crimson left border.

Use the visual treatment from the reference.

The notice should communicate that access is subject to:

- IT security policies
- Acceptable use policies
- Authorized institutional use

IMPORTANT:

Do not invent specific university policy names.

Do not invent legal claims.

Use generic configurable wording until official policy information is available.

---

# 17. SUPPORT CENTER CONFIGURATION

The project currently does NOT have official IT Helpdesk contact information.

Therefore:

> The Agent MUST NOT invent a phone number, email address, URL, university department, or support contact.

The Support Center UI should be implemented as a configurable placeholder.

For example:

```text
Support Center

IT Helpdesk contact information will be added here.
```

or an equivalent neutral placeholder matching the visual design.

The placeholder should be easy to replace later.

Recommended configuration approach:

```text
config/support.php
```

or an equivalent existing project configuration mechanism.

Potential configuration values:

```text
support.name
support.email
support.phone
support.url
```

Use empty/null defaults until official information is available.

Example conceptual configuration:

```php
return [
    'name' => null,
    'email' => null,
    'phone' => null,
    'url' => null,
];
```

Do not expose empty clickable links.

If a value is empty, hide the corresponding contact action while preserving the layout.

---

# 18. FORGOT PASSWORD PAGE

## Reference

Inspect:

```text
design_references/screen (8).jpg
```

or the actual corresponding extension.

---

## Layout

Use:

- Centered authentication card
- Light background
- Crimson top border
- Responsive layout

The card must have:

```text
border-radius: 0px
```

---

## Required Elements

### Heading

```text
Reset Password
```

Use Montserrat.

---

### Institutional Email

Required input.

Use the existing Laravel password reset request logic.

Do not change the password reset architecture unnecessarily.

---

### Send Reset Link

Button:

```text
Send Reset Link
```

Use Navy.

The button must submit the existing password reset request.

---

### Return to Login

Use Crimson.

Must point to the existing login route.

---

# 19. SUPPORT CENTER — FORGOT PASSWORD

The reference includes a left-aligned Support Center block on desktop.

Requirements:

- Visible on desktop.
- Hidden, stacked, or repositioned appropriately on mobile.
- Must not cause horizontal overflow.
- Must not invent contact information.

Use the configurable support values described in Section 17.

If no official support information exists, display a neutral placeholder.

---

# 20. PASSWORD RESET LINK SENT

## Reference

Inspect:

```text
design_references/screen (7).jpg
```

or the actual corresponding extension.

---

## Required Elements

### Success Icon

Use a circular Crimson icon container.

The icon should communicate:

- Email
- Confirmation
- Success

---

### Heading

```text
Link Sent!
```

---

### Open Email App

Primary Navy button:

```text
Open Email App
```

If no specific email provider is configured, use a generic email-client action where appropriate.

Do not invent a provider.

If browser restrictions prevent reliable email-app launching, the button must fail gracefully.

---

### Resend

Display:

```text
Didn't receive it? Resend Link
```

The resend action must connect to the existing password reset request flow where possible.

Do not create a duplicate reset-token implementation.

---

### Back to Login

Link to the existing login route.

---

# 21. CREATE NEW PASSWORD PAGE

## Reference

Inspect:

```text
design_references/screen (11).jpg
```

or the actual corresponding extension.

---

## Layout

Use a centered authentication card.

The card should have the partially split top-border treatment shown in the screenshot.

Use the project Navy and Crimson colors.

---

# 22. NEW PASSWORD FIELD

Include:

- New Password label
- Password input
- Visibility toggle
- Eye icon

The visibility toggle MUST use Alpine.js.

---

# 23. PASSWORD STRENGTH INDICATOR

Implement a dynamic password strength indicator using Alpine.js.

The indicator should react as the user types.

At minimum, distinguish states such as:

```text
Empty
Weak
Medium
Strong
```

The exact thresholds should be aligned with the project's actual password validation rules.

Do not create a UI that claims a password is valid when Laravel will reject it.

---

# 24. PASSWORD REQUIREMENTS CHECKLIST

Implement a dynamic checklist using Alpine.js.

Required requirements:

- [ ] At least 8 characters
- [ ] Contains uppercase letter
- [ ] Contains lowercase letter
- [ ] Contains number
- [ ] Contains special character

The checklist must update immediately as the user types.

Use visual states such as:

- Neutral
- Incomplete
- Complete

Do not rely exclusively on color.

Use icons/text in addition to color.

---

# 25. CONFIRM PASSWORD

Include:

```text
Confirm New Password
```

with a visibility toggle where appropriate.

The UI must clearly indicate when:

- Passwords match.
- Passwords do not match.

---

# 26. RESET PASSWORD BUTTON

Display:

```text
Reset Password
```

Use Navy.

The button should be disabled when the client-side requirements are clearly incomplete.

IMPORTANT:

Client-side validation is only a UX enhancement.

The server-side Laravel validation remains authoritative.

Do not remove server-side validation.

---

# 27. PASSWORD VALIDATION CONSISTENCY

The password requirements displayed by Alpine.js MUST correspond to the actual Laravel backend password validation.

The Agent MUST inspect the existing password validation rules before implementing the strength/checklist UI.

If the backend currently requires different rules:

1. Preserve the existing security policy unless the project specification explicitly requires changing it.
2. Update the UI to accurately reflect the backend requirements.
3. Do not create conflicting client/server requirements.

---

# 28. PUBLIC REGISTRATION POLICY

Open registration is NOT part of this project.

The Account Request page replaces public registration.

The Agent MUST inspect the existing authentication scaffolding.

If a registration route or registration link exists:

- Do not expose it as a normal public registration option.
- Remove registration links from authentication navigation.
- Preserve the existing authentication architecture.
- Do not delete backend registration code unless it is confirmed to be unused and removal is safe.

The primary user-facing flow should be:

```text
Login
  │
  ├── Forgot Password
  │
  └── Account Request
```

not:

```text
Login
  │
  └── Register
```

---

# 29. INSTITUTIONAL SSO POLICY

Institutional SSO is currently NOT configured.

Therefore:

- Do not add OAuth.
- Do not add SAML.
- Do not add Google login.
- Do not add Microsoft login.
- Do not add Azure AD.
- Do not add Okta.
- Do not invent an SSO endpoint.
- Do not add credentials.

Implement the visual SSO button according to the reference.

Keep its actual integration configurable for future implementation.

---

# 30. LEGAL LINKS POLICY

The project currently does not have finalized:

- Privacy Policy
- Terms of Service

Do not invent legal documents.

The UI should contain configurable links.

If pages do not yet exist:

- Keep the visual link.
- Point to a safe placeholder route only if such a route exists.
- Otherwise use a non-destructive placeholder.
- Do not create fake legal content.

The links must be easy to connect later.

---

# 31. INSTITUTIONAL CONTACT POLICY

The project currently has no official:

- IT Helpdesk email
- IT Helpdesk phone number
- Support URL
- University support department name

The Agent MUST leave these values empty/configurable.

Never fabricate contact information.

Future values should be able to be added without redesigning the authentication pages.

---

# 32. ALPINE.JS REQUIREMENTS

Use Alpine.js for lightweight authentication interactions.

Required Alpine.js features:

1. Password visibility toggle.
2. Password strength indicator.
3. Password requirements checklist.
4. Password confirmation matching.
5. Optional small UI states where appropriate.

Do NOT introduce:

- React
- Vue
- jQuery
- Heavy client-side frameworks
- Additional state-management libraries

unless explicitly required.

---

# 33. RESPONSIVE REQUIREMENTS

Authentication pages must work on:

- Desktop
- Laptop
- Tablet
- Mobile

Desktop:

- Centered card
- Appropriate whitespace
- Support Center may appear beside the card where required by the reference

Mobile:

- Card should occupy nearly the full available width.
- Maintain safe horizontal padding.
- Support content should stack naturally.
- Inputs must remain usable.
- Buttons should remain accessible.
- No horizontal overflow.

Never use fixed widths that cause mobile overflow.

---

# 34. ACCESSIBILITY

Authentication forms must include:

- Proper `<label>` elements
- Accessible input names
- Keyboard navigation
- Visible focus states
- Accessible buttons
- Appropriate `autocomplete` attributes
- Accessible error messages
- Screen-reader-friendly status messages where appropriate

Password visibility controls must have accessible labels.

Example concept:

```text
Show password
Hide password
```

Do not rely exclusively on an eye icon without an accessible name.

---

# 35. FORM VALIDATION UX

Validation errors should:

- Appear near the relevant field.
- Be understandable.
- Preserve previously entered non-sensitive values where appropriate.
- Never redisplay plaintext passwords after failed submission.

Use Laravel's existing validation/error handling.

Do not duplicate backend validation unnecessarily.

---

# 36. SECURITY REQUIREMENTS

Preserve Laravel security mechanisms.

Authentication pages must retain:

- CSRF protection
- Session security
- Password hashing
- Password reset token security
- Rate limiting where already configured
- Server-side validation
- Authorization middleware
- Secure password handling

Never log:

- Passwords
- Reset tokens
- Authentication credentials

Do not expose sensitive values in browser-visible error messages.

---

# 37. FILE UPDATES

Primary files likely to be modified:

```text
resources/views/auth/
resources/views/layouts/
resources/views/components/
resources/css/
```

Only modify backend files if required.

Potential backend files that MAY require minimal changes:

```text
routes/
app/Http/Controllers/
app/Http/Requests/
app/Models/
config/
```

The Agent MUST inspect the current implementation before modifying any of them.

---

# 38. CONFIGURATION FOR FUTURE SUPPORT INFORMATION

If support information does not already have a configuration mechanism, create a small configuration file such as:

```text
config/support.php
```

Potential structure:

```php
<?php

return [
    'name' => env('SUPPORT_NAME'),
    'email' => env('SUPPORT_EMAIL'),
    'phone' => env('SUPPORT_PHONE'),
    'url' => env('SUPPORT_URL'),
];
```

Add corresponding empty values to `.env.example` if appropriate:

```env
SUPPORT_NAME=
SUPPORT_EMAIL=
SUPPORT_PHONE=
SUPPORT_URL=
```

Do NOT add fake values to `.env`.

Only add configuration if it fits the existing architecture.

---

# 39. IMPLEMENTATION WORKFLOW

The Agent MUST follow this sequence.

## PHASE 1 — AUTHENTICATION AUDIT

Do NOT modify files yet.

Inspect:

1. Laravel version.
2. Authentication package.
3. Authentication routes.
4. Authentication controllers.
5. Authentication middleware.
6. Password reset implementation.
7. User model.
8. User migration.
9. Existing authentication Blade views.
10. Existing layouts/components.
11. Tailwind configuration.
12. Alpine.js setup.
13. `design_references/`.
14. Existing support/contact configuration if any.

Then report:

- Authentication package
- Relevant routes
- Relevant controllers
- Relevant views
- Existing password rules
- Existing registration behavior
- Files that need modification
- Files that should remain untouched

---

# 40. PHASE 2 — DESIGN MAPPING

Before implementation, map each reference to its corresponding existing view.

Example:

```text
screen (9)  → login
screen (10) → account request
screen (8)  → forgot password
screen (7)  → reset link sent
screen (11) → new password
```

Inspect the actual screenshots.

Identify:

- Dimensions
- Card width
- Spacing
- Typography
- Icon placement
- Borders
- Button sizes
- Responsive implications

Do not implement before understanding the references.

---

# 41. PHASE 3 — AUTHENTICATION UI

Implement in this order:

1. Shared authentication layout
2. Login
3. Forgot Password
4. Reset Link Sent
5. Create New Password
6. Account Request
7. Shared form components
8. Support Center
9. Footer/legal links

Reuse components where appropriate.

---

# 42. PHASE 4 — FUNCTIONAL VERIFICATION

After implementation:

1. Test login.
2. Test logout.
3. Test remember-me.
4. Test forgot password.
5. Test reset link flow.
6. Test password validation.
7. Test password visibility.
8. Test password strength indicator.
9. Test confirmation matching.
10. Test Account Request validation.
11. Test responsive layouts.

Do not consider the task complete if only the UI renders.

---

# 43. PHASE 5 — REGRESSION CHECK

Verify that the following remain functional:

- Public homepage
- News archive
- Research page
- Article page
- CMS
- Existing admin authentication
- Database
- Existing navigation
- Existing article functionality

Do not introduce authentication changes that break the existing portal.

---

# 44. DESIGN QUALITY CHECKLIST

Before completion:

- [ ] Matches login reference.
- [ ] Matches account request reference.
- [ ] Matches forgot-password reference.
- [ ] Matches link-sent reference.
- [ ] Matches new-password reference.
- [ ] Navy and Crimson colors are correct.
- [ ] Background is correct.
- [ ] Typography is correct.
- [ ] Cards use 0px radius.
- [ ] Inputs use 0px radius.
- [ ] Buttons use 0px radius.
- [ ] Circular icons are used only where appropriate.
- [ ] Borders are subtle.
- [ ] No unnecessary shadows.
- [ ] Mobile layout works.
- [ ] No horizontal overflow.

---

# 45. FUNCTIONAL ACCEPTANCE CRITERIA

## Login

- [ ] Login page visually matches `screen (9)`.
- [ ] Existing authentication endpoint is preserved.
- [ ] Email/NetID field works with the existing identifier.
- [ ] Password input works.
- [ ] Password visibility toggle works.
- [ ] Forgot Password link works.
- [ ] Remember-me works.
- [ ] Sign In works.
- [ ] SSO button is visually implemented without fake integration.
- [ ] Footer links are present/configurable.
- [ ] Validation errors display correctly.

---

## Account Request

- [ ] Page visually matches `screen (10)`.
- [ ] Full Name works.
- [ ] Institutional Email works.
- [ ] Department / Role works.
- [ ] Server-side validation works.
- [ ] Request Access action works according to the existing backend architecture.
- [ ] Return to Login works.
- [ ] Security notice exists.
- [ ] No fake IT contact information is displayed.

---

## Forgot Password

- [ ] Page visually matches `screen (8)`.
- [ ] Institutional Email works.
- [ ] Send Reset Link works.
- [ ] Existing Laravel password reset flow is preserved.
- [ ] Return to Login works.
- [ ] Support Center appears on desktop.
- [ ] Support information remains configurable.
- [ ] No fake email or phone number is shown.

---

## Link Sent

- [ ] Page visually matches `screen (7)`.
- [ ] Success icon exists.
- [ ] Link Sent heading exists.
- [ ] Open Email App button exists.
- [ ] Resend Link works.
- [ ] Back to Login works.
- [ ] No fake email provider is assumed.

---

## Create New Password

- [ ] Page visually matches `screen (11)`.
- [ ] New Password field works.
- [ ] Visibility toggle works.
- [ ] Strength indicator works.
- [ ] Requirement checklist works.
- [ ] Confirm Password works.
- [ ] Mismatch state is displayed.
- [ ] Reset button state responds appropriately.
- [ ] Backend Laravel validation remains authoritative.
- [ ] Existing reset-token logic remains functional.

---

# 46. GENERAL ACCEPTANCE CRITERIA

The implementation must satisfy:

- [ ] No existing core portal functionality is broken.
- [ ] No duplicate authentication routes are created unnecessarily.
- [ ] No fake institutional data is introduced.
- [ ] No fake IT contact information is introduced.
- [ ] No fake SSO provider is introduced.
- [ ] No fake legal information is introduced.
- [ ] No passwords or reset tokens are exposed.
- [ ] No unnecessary dependencies are installed.
- [ ] Alpine.js is used for required interactions.
- [ ] Authentication pages are responsive.
- [ ] Authentication pages are accessible.
- [ ] Existing authentication backend remains functional.

---

# 47. TESTING REQUIREMENTS

Run appropriate tests after implementation.

At minimum:

```bash
php artisan test
```

Build frontend assets:

```bash
npm run build
```

Verify routes:

```bash
php artisan route:list
```

If appropriate for the development environment:

```bash
php artisan migrate:status
```

Do not use destructive commands such as:

```bash
php artisan migrate:fresh
```

unless the Agent has verified that the environment is safe for database reset.

---

# 48. BROWSER VERIFICATION

The Agent should manually verify the following pages in a browser:

```text
/login
/forgot-password
/reset-password/{token}
/account-request
```

and the success state after requesting a reset link.

Check:

- Desktop
- Tablet
- Mobile
- Form interactions
- Validation
- Password toggles
- Password strength
- Button states
- Links
- No console errors
- No layout overflow

---

# 49. DO NOT INVENT INFORMATION

This is an independent personal project and does not currently have finalized institutional information.

The Agent MUST NOT invent:

- University name
- University logo
- IT department name
- IT helpdesk email
- Phone number
- Support URL
- SSO provider
- Institutional email domain
- Privacy Policy content
- Terms of Service content
- Official department list

If information is not available:

1. Leave it configurable.
2. Use a neutral placeholder.
3. Keep the visual structure intact.
4. Make it easy to replace later.

Never present fabricated information as official.

---

# 50. FUTURE CONFIGURATION POINTS

The authentication UI should be designed so the following can be added later without major UI restructuring:

```text
Institution Name
Institution Logo
Institution Email Domain
IT Helpdesk Name
IT Helpdesk Email
IT Helpdesk Phone
Support URL
Privacy Policy URL
Terms of Service URL
SSO Provider
SSO URL
Department List
Role List
```

These should preferably be configurable through existing Laravel configuration mechanisms.

Do not implement unnecessary configuration infrastructure if the existing project already provides a suitable mechanism.

---

# 51. CODE QUALITY RULES

Follow Laravel conventions.

Use:

- Blade components
- Form Requests where appropriate
- Eloquent relationships
- Policies/middleware where required
- Named routes
- Existing authentication infrastructure
- Tailwind utilities
- Alpine.js for lightweight interactivity

Avoid:

- Massive Blade files
- Inline duplicated JavaScript
- Unnecessary custom CSS
- Hardcoded institutional data
- Duplicate authentication logic
- Unnecessary packages
- Unnecessary database changes

---

# 52. FINAL AGENT REPORT

After completing the work, provide a concise report containing:

## Authentication Architecture

Identify the authentication system that was found.

## Files Modified

List every file changed.

## Files Created

List every new file created.

## UI Implemented

List:

- Login
- Account Request
- Forgot Password
- Reset Link Sent
- Create New Password

## Backend Changes

Clearly state whether any backend authentication logic was modified.

If no backend changes were required, explicitly state:

```text
Existing authentication backend was preserved.
```

## Configuration

List any newly configurable values such as:

- Support email
- Support phone
- Support URL
- Legal URLs
- SSO configuration

## Testing

Report:

```text
php artisan test
npm run build
php artisan route:list
```

and their results.

## Remaining Work

Explicitly identify anything that remains unconfigured, especially:

- IT contact information
- SSO
- Legal pages
- Institutional branding

Do not claim completion for features that were not actually tested.

---

# 53. DEFINITION OF DONE

This task is complete only when:

1. Existing authentication architecture has been inspected.
2. Existing authentication logic has been preserved.
3. All five authentication/onboarding views have been implemented.
4. All five design references have been inspected.
5. Login works.
6. Logout still works.
7. Forgot password works.
8. Password reset works.
9. Password strength UI works.
10. Password visibility toggles work.
11. Account Request works according to the existing project architecture.
12. Public registration is not exposed as the primary registration flow.
13. No fake institutional information has been introduced.
14. Support information is configurable.
15. Authentication pages are responsive.
16. Authentication pages follow the project design system.
17. Tests pass.
18. Frontend build succeeds.
19. Existing public portal functionality remains intact.
20. No major console/browser errors remain.

---

# 54. START HERE

When this document is provided to the Agent:

**DO NOT MODIFY CODE IMMEDIATELY.**

First:

1. Read `DESIGN.md`.
2. Read this `AUTHENTICATION.md`.
3. Inspect the entire existing project.
4. Inspect the current authentication architecture.
5. Inspect `design_references/`.
6. Locate the five authentication screenshots.
7. Inspect the existing authentication Blade views.
8. Inspect authentication routes/controllers.
9. Inspect existing password validation rules.
10. Inspect existing registration behavior.
11. Identify exactly which files need modification.

Then report:

```text
1. Current authentication architecture
2. Current authentication routes
3. Current authentication views
4. Current password validation rules
5. Current registration behavior
6. Design references found
7. Files that will be modified
8. Files that will remain untouched
9. Proposed implementation sequence
10. Potential risks
```

**Do not begin implementation until this audit has been completed.**

After the audit, proceed with the implementation phases in this document.

---

# END OF AUTHENTICATION SPECIFICATION
