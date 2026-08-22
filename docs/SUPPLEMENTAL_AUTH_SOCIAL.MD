# SUPPLEMENTAL PROJECT SPECIFICATION: AUTHENTICATION, PUBLIC ACCESS, AUTHOR REQUEST & GOOGLE LOGIN

## 1. PROJECT CONTEXT

This document is an authentication and authorization specification for an EXISTING and FUNCTIONING Laravel University News Portal project.

The application is an INDEPENDENT university-themed news portal project created by an external developer/team.

IMPORTANT:

This is NOT an official university authentication system.

Therefore:

- DO NOT implement institutional SSO.
- DO NOT implement university SAML.
- DO NOT implement Shibboleth.
- DO NOT implement Azure AD / Microsoft institutional authentication.
- DO NOT implement Apple Sign-In.
- DO NOT assume the application has access to an official university identity provider.

The authentication system must instead support:

1. Public Reader accounts
2. Author accounts
3. Dedicated Admin authentication
4. Google OAuth for Public Readers
5. Optional local password for Google-created accounts
6. Author account request and admin approval

The system must remain simple enough for the current project while maintaining a secure architecture that can be extended later.

============================================================ 2. AUTHENTICATION ARCHITECTURE
============================================================

The application has THREE logical account roles:

- reader
- author
- admin

IMPORTANT:

"Guest" is NOT a database role.

A visitor who is not authenticated is simply an unauthenticated guest.

Therefore:

Guest
↓
Login / Register
↓
Reader

Reader
↓
Approved Author Request
↓
Author

Admin remains a separate privileged account type.

The role hierarchy MUST NOT allow users to promote themselves.

A user must NEVER be able to select:

- admin
- author

from a normal public registration form.

============================================================ 3. LOGIN ENTRY POINTS
============================================================

There are TWO separate login entry points.

---

## 3.1 PUBLIC / STAFF LOGIN

Primary login route:

/login

This page is used for:

- Reader login
- Author login

Supported authentication methods:

1. Email + local password
2. Continue with Google

Google authentication is primarily intended for Public Readers.

Existing Authors may continue using email/password if they have a local password.

IMPORTANT:

The /login page MUST NOT provide:

- Admin login
- Admin role selection
- Role dropdown
- "Login as Admin"
- Institutional SSO
- Apple Login

---

## 3.2 ADMIN LOGIN

Dedicated admin login path:

/admin/sign-in

This route MUST be separate from /login.

The Admin login page is intended ONLY for users whose role is:

admin

The Admin login page must use:

- Email
- Password
- Existing security protections
- Optional future 2FA support

The Admin login page MUST NOT provide:

- Google Login
- Apple Login
- Institutional SSO
- Public registration
- Author registration
- Role selection

If a non-admin account attempts to authenticate through:

/admin/sign-in

the authentication MUST NOT grant admin access.

If the credentials belong to a reader or author, reject the admin login attempt and display an appropriate generic error.

DO NOT change the user's role automatically.

============================================================ 4. ROLE SECURITY
============================================================

The application MUST use server-side authorization.

Do NOT rely only on hiding UI elements.

Expected behavior:

reader
→ Public pages
→ Comments
→ Ratings
→ Reader profile
→ Cannot access admin/author CMS functionality

author
→ Public pages
→ Comments
→ Ratings
→ Author/CMS functionality allowed by existing authorization rules
→ Cannot access admin-only functionality

admin
→ Admin dashboard
→ User management
→ Author approval
→ CMS management
→ Administrative functionality

Every protected route MUST use appropriate middleware / authorization.

At minimum:

/admin/\*
→ authenticated
→ admin role required

Author/CMS routes:
→ authenticated
→ author or admin role as appropriate

Do NOT rely on URL obscurity for security.

============================================================ 5. GOOGLE SOCIAL LOGIN
============================================================

Implement Google OAuth using Laravel Socialite.

Install:

laravel/socialite

ONLY if Socialite is not already installed.

Do NOT install Apple Socialite integration.

Do NOT implement institutional SSO.

---

## 5.1 GOOGLE ROUTES

Use routes similar to:

/auth/google/redirect
/auth/google/callback

Use named routes where appropriate.

Example conceptual names:

auth.google.redirect
auth.google.callback

Inspect the existing routing structure before creating routes.

Do NOT create duplicate routes.

---

## 5.2 GOOGLE LOGIN PURPOSE

Google Login is intended for PUBLIC READER accounts.

A Google OAuth login MUST NEVER automatically create:

- author
- admin
- editor
- staff
- any privileged role

If a new user is created through Google:

role = reader

ONLY.

============================================================ 6. GOOGLE ACCOUNT CREATION
============================================================

When a user selects:

"Continue with Google"

the application should:

1. Redirect to Google.
2. Authenticate the user.
3. Retrieve verified identity information.
4. Retrieve:
    - name
    - email
    - provider ID
5. Determine whether the Google identity already exists.

Preferred lookup:

provider = google
provider_id = Google's unique user identifier

---

## 6.1 EXISTING GOOGLE USER

If the Google provider ID already exists:

→ Authenticate that existing user.

Do NOT create another account.

---

## 6.2 NEW GOOGLE USER

If the Google provider ID does not exist:

Check whether the email already belongs to an existing account.

IMPORTANT:

DO NOT blindly auto-link Google authentication to an existing privileged account merely because the email matches.

If an existing account has:

role = admin
OR
role = author

do NOT automatically attach Google OAuth to that account.

Require an explicit and secure account-linking flow later if such functionality is introduced.

For a normal new public user:

Create:

role = reader
provider = google
provider_id = Google user ID
password = NULL

Then authenticate the reader.

============================================================ 7. GOOGLE USER WITH NO LOCAL PASSWORD
============================================================

Google-created users may have:

password = NULL

This is intentional.

Example:

User:
name = John Doe
email = john@gmail.com
role = reader
provider = google
provider_id = xxxxx
password = NULL

This means:

The user can log in using Google.

The user CANNOT log in using:

Email + Password

because no local password has been configured.

The application MUST NOT generate a fake password.

The application MUST NOT store an empty string as a password.

The password must remain NULL until the user explicitly creates a local password.

============================================================ 8. OPTIONAL LOCAL PASSWORD FOR GOOGLE USERS
============================================================

Google users MAY optionally create a local password.

This is NOT mandatory.

After successfully authenticating with Google, the application may display a non-blocking notification such as:

"Your account currently uses Google Sign-In.
You can optionally create a local password for an additional login method."

Example actions:

[Create Local Password]

or:

[Maybe Later]

This notification should NOT prevent the user from using the website.

---

## 8.1 CREATE LOCAL PASSWORD FLOW

A Google-authenticated user with:

password = NULL

may access a secure:

"Create Local Password"

flow.

The user provides:

- New Password
- Confirm New Password

Use the existing password validation rules.

Use Laravel's secure password hashing mechanism.

NEVER store plaintext passwords.

After successfully creating the password:

password != NULL

The user can then authenticate using either:

Google
OR
Email + Password

---

## 8.2 GOOGLE USER LOGIN OPTIONS

Before local password creation:

Google:
YES

Email + Password:
NO

After local password creation:

Google:
YES

Email + Password:
YES

This behavior must be enforced server-side.

============================================================ 9. FORGOT PASSWORD BEHAVIOR
============================================================

The "Forgot Password?" flow applies to users who have a local password.

If a Google-only user has:

password = NULL

the system should NOT pretend that a local password exists.

If they attempt:

Forgot Password?

display a clear message such as:

"This account currently uses Google Sign-In.
Please continue with Google, or create a local password after signing in."

Do NOT send a meaningless password-reset email for an account that has no local password.

If the user has a local password:

Use the existing Laravel password reset mechanism.

Do not rebuild password reset functionality unnecessarily.

============================================================ 10. PUBLIC READER REGISTRATION
============================================================

Public users may register normally.

Public registration must create ONLY:

role = reader

The public registration form should contain:

- Full Name
- Email
- Password
- Confirm Password
- Terms of Service agreement
- Privacy Policy agreement
- CAPTCHA / anti-bot protection

The public user MUST NOT be able to select a role.

Do NOT include:

- Admin
- Author
- Editor
- Staff
- University

as selectable roles in the public registration form.

---

## 10.1 PUBLIC REGISTRATION FLOW

Expected flow:

/register

    ↓

Full Name
Email
Password
Confirm Password
Terms & Privacy
CAPTCHA

    ↓

Create Reader Account

    ↓

role = reader

    ↓

Login / verification flow

============================================================ 11. PUBLIC REGISTRATION SECURITY
============================================================

Public registration should use appropriate anti-abuse protection.

Preferred options:

- Cloudflare Turnstile
  OR
- Google reCAPTCHA

Do NOT hardcode production credentials.

Use environment variables.

Example:

CAPTCHA_SITE_KEY=
CAPTCHA_SECRET_KEY=

If credentials are not yet configured:

- Build the integration in a configurable manner.
- Do not break registration.
- Do not pretend CAPTCHA verification is active when it is not configured.
- Clearly document the configuration requirement.

Also preserve Laravel's:

- CSRF protection
- validation
- password hashing
- rate limiting where appropriate

============================================================ 12. TERMS OF SERVICE & PRIVACY
============================================================

Public registration must include a required checkbox:

"I agree to the Terms of Service and Privacy Policy."

The checkbox must be validated server-side.

The user must not be able to submit registration without accepting it.

Use existing routes/pages for:

- Terms of Service
- Privacy Policy

if they already exist.

If they do not exist, do NOT create elaborate legal documents.

Create only the necessary placeholder links/components if the current architecture requires them.

============================================================ 13. AUTHOR ACCOUNT REQUEST
============================================================

Author accounts MUST NOT be created through normal public registration.

Instead, provide a separate:

"Request Account as Author"

flow.

Possible navigation:

Register
↓
Choose account type

    ┌──────────────────────┐
    │ Public Reader        │
    └──────────────────────┘

    ┌──────────────────────┐
    │ Request as Author    │
    └──────────────────────┘

The author request flow must clearly explain:

"Author accounts require administrative approval."

============================================================ 14. AUTHOR REQUEST — EXISTING READER
============================================================

If a logged-in reader wants to become an author:

Use their EXISTING account.

The request must use the SAME email address associated with the reader account.

Do NOT create a duplicate user account with the same email.

Example:

Existing account:

name:
John Doe

email:
john@example.com

role:
reader

User selects:

"Request Account as Author"

The request form may prefill:

Full Name
Email

The email should NOT be arbitrarily changed to another email.

Additional required information:

- University
- Optional Department / Field if appropriate

Example:

Full Name:
John Doe

Email:
john@example.com

University:
ABC University

Department:
Computer Engineering

Submit:

"Request Author Access"

============================================================ 15. AUTHOR REQUEST — UNREGISTERED USER
============================================================

If the application allows an unauthenticated visitor to submit an author request:

The visitor must provide:

- Full Name
- Email
- Password
- Confirm Password
- University
- Optional Department / Field
- Terms & Privacy
- CAPTCHA

However, do NOT automatically activate the account as an author.

The request remains:

status = pending

The system must prevent privileged access until an administrator approves the request.

If the project architecture already requires authentication before author requests, prefer that approach.

Do not create duplicate users.

============================================================ 16. AUTHOR REQUEST DATABASE DESIGN
============================================================

Inspect the existing database before creating new tables.

If no suitable request structure exists, create a dedicated table such as:

author_account_requests

Possible fields:

- id
- user_id nullable
- name
- email
- university
- department nullable
- status
- reviewed_by nullable
- reviewed_at nullable
- rejection_reason nullable
- created_at
- updated_at

Recommended status values:

pending
approved
rejected

IMPORTANT:

NEVER store plaintext passwords in the author request table.

If a password is collected during an unauthenticated request, hash it securely or, preferably, use a secure account setup flow after approval.

Do NOT store raw passwords.

============================================================ 17. AUTHOR APPROVAL WORKFLOW
============================================================

Author requests must be reviewed by an Admin.

Expected workflow:

Reader/User
↓
Request Author Account
↓
status = pending
↓
Admin Dashboard
↓
Review Request
↓
Approve OR Reject

---

## 17.1 APPROVE

When approved:

The corresponding user becomes:

role = author

ONLY after approval.

If the request belongs to an existing reader:

reader
↓
approved request
↓
author

Do NOT create a second account.

---

## 17.2 REJECT

If rejected:

status = rejected

The user remains:

role = reader

if an existing reader account exists.

The user MUST NOT gain author privileges.

============================================================ 18. ADMIN AUTHOR REQUEST MANAGEMENT
============================================================

Admin dashboard should eventually provide:

- Pending author requests
- Applicant name
- Applicant email
- University
- Department
- Request date
- Status
- Approve action
- Reject action

This must be protected by:

admin authorization

Do NOT expose pending author requests publicly.

============================================================ 19. ADMIN AUTHENTICATION
============================================================

Admin authentication is COMPLETELY SEPARATE from public login.

Admin login path:

/admin/sign-in

Do NOT redirect administrators through:

/login

unless the existing architecture absolutely requires it.

The preferred architecture is:

/login
→ reader / author

/admin/sign-in
→ admin

The Admin login form should contain:

- Email
- Password
- Sign In

Optional future:

- Remember me
- 2FA

Do NOT include Google Login on the admin sign-in page.

============================================================ 20. ADMIN ROLE PROTECTION
============================================================

Even if someone manually navigates to:

/admin/dashboard

they must NOT gain access unless:

1. They are authenticated.
2. Their role is admin.

Example:

reader → /admin/dashboard → 403 / unauthorized
author → /admin/dashboard → 403 / unauthorized
admin → /admin/dashboard → allowed

Use server-side middleware / policies.

Do NOT rely on frontend visibility.

============================================================ 21. AUTHOR ROLE PROTECTION
============================================================

Authors may access only author-appropriate CMS functionality.

Readers must not access author CMS functionality.

Do not modify existing authorization architecture unnecessarily.

If the application already has role middleware:

REUSE IT.

If it does not:

Implement the minimum required middleware cleanly.

============================================================ 22. LOGIN PAGE UI
============================================================

The public login page:

/login

must follow the existing authentication design system.

Use:

Primary Navy:
#00081e

Crimson:
#b71032

Background:
#fcf8f9

Surface:
#ffffff

Border:
#c5c6cf

Typography:

Headings:
Montserrat

Labels / buttons:
Work Sans

Body:
Source Serif 4 where appropriate

All primary containers, inputs and buttons:

border-radius: 0

Do NOT introduce rounded modern card styles.

---

## 22.1 LOGIN OPTIONS

The public login page should contain:

Email / NetID
Password
Forgot Password?
Remember / Keep me signed in where supported
Sign In

Then:

OR

Continue with Google

Remove:

Institutional SSO

Remove:

Continue with Apple

There must be NO Apple button.

There must be NO SSO button.

============================================================ 23. GOOGLE BUTTON
============================================================

Use:

"Continue with Google"

Use an appropriate Google brand icon if the project already has an icon library.

Do NOT add a new icon library unnecessarily.

The Google button must redirect to the existing Google Socialite route.

Do not make the button a fake visual element.

============================================================ 24. LOGIN ERROR FEEDBACK
============================================================

If the existing design already supports validation/error states:

preserve them.

A subtle shake animation may be added for authentication errors.

Do NOT make the animation excessive.

Do not add heavy JavaScript.

Prefer:

- CSS animation
- Alpine.js if already available

Do not introduce a new frontend framework.

============================================================ 25. PUBLIC ARTICLE COMMENT FLOW
============================================================

On article pages:

If guest:

Display:

"Login with Google to Comment"

or:

"Login to Comment"

The button may redirect to Google authentication.

IMPORTANT:

After successful Google authentication, the user should ideally be redirected back to the article they originally wanted to interact with.

Preserve the intended URL securely.

Do NOT allow unsafe open redirects.

If the user is authenticated as reader or author:

Display the comment input.

If the user is not authorized to comment:

display an appropriate message.

============================================================ 26. ARTICLE RATING
============================================================

If the project already supports article rating:

Unauthenticated users should be prompted to authenticate.

Authenticated readers/authors may rate according to existing business rules.

Do not implement a rating system from scratch unless the project already contains the necessary structure.

This document only defines authentication access behavior.

============================================================ 27. PASSWORD UI
============================================================

Public registration and local password creation should include:

- Password visibility toggle
- Confirm password
- Password strength indicator
- Password requirement checklist

Use Alpine.js if already available.

Do NOT introduce another JavaScript framework.

Recommended requirements:

- Minimum 8 characters
- Uppercase character
- Lowercase character
- Number
- Special character

The exact validation rules MUST match the server-side Laravel validation.

Client-side validation is NOT a replacement for server-side validation.

============================================================ 28. GOOGLE-ONLY USER PASSWORD NOTICE
============================================================

When a Google user has:

password = NULL

display a non-blocking notice after authentication or inside the account/profile area:

"Your account currently uses Google Sign-In only.
You can optionally create a local password to sign in with your email and password."

Action:

"Create Local Password"

Secondary action:

"Maybe Later"

This notification must NOT prevent normal website usage.

Do not repeatedly display an intrusive modal every time the user logs in.

Prefer:

- account/profile notice
- dismissible banner
- one-time notification

============================================================ 29. ACCOUNT LINKING SAFETY
============================================================

Do NOT automatically link Google to privileged accounts based only on email address.

Example:

Existing:

email = admin@example.com
role = admin
provider = NULL

Someone authenticates through Google using:

admin@example.com

DO NOT automatically set:

provider = google

and authenticate the user.

For now, Google authentication should be treated as a public-reader authentication mechanism.

Future account-linking functionality may be implemented explicitly through an authenticated account settings flow.

============================================================ 30. USER MODEL
============================================================

Inspect the existing User model before modifying it.

If OAuth fields do not already exist, add:

provider nullable
provider_id nullable

The password field may need to become nullable to support Google-only accounts.

Use a new migration.

DO NOT modify existing production data destructively.

NEVER run:

php artisan migrate:fresh

NEVER drop the users table.

If existing users already have local passwords:

preserve them.

Existing users must continue to work.

============================================================ 31. DATABASE CONSTRAINTS
============================================================

If appropriate for the existing database architecture:

provider_id should be indexed.

Consider a unique constraint on the combination:

provider
provider_id

while allowing NULL values for local accounts.

Inspect PostgreSQL behavior and existing schema before applying constraints.

Do not blindly create constraints that break existing data.

============================================================ 32. SOCIALITE CONFIGURATION
============================================================

Add Google credentials through environment variables.

Example:

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=

Update the appropriate Laravel configuration file.

DO NOT hardcode secrets.

Update:

.env.example

with placeholders only.

Never commit actual credentials.

============================================================ 33. GOOGLE CALLBACK SECURITY
============================================================

The callback implementation must:

- Validate the OAuth response.
- Use the provider's unique identifier.
- Prefer verified email information where available.
- Avoid duplicate accounts.
- Never automatically grant privileged roles.
- Handle cancelled/failed authentication gracefully.
- Log the user in through Laravel's standard authentication system.

Do not trust client-submitted role information.

============================================================ 34. EMAIL VERIFICATION
============================================================

Inspect the existing Laravel authentication architecture.

If email verification already exists:

reuse it.

For Google accounts:

use the provider's verified email information when available.

Do not invent a custom email verification system if Laravel's existing functionality is sufficient.

============================================================ 35. PASSWORD RESET
============================================================

Preserve the existing Laravel password reset architecture.

For users with:

password != NULL

normal password reset is allowed.

For Google-only users:

password = NULL

do not pretend they have a local password.

Guide them to:

Continue with Google

or:

Create Local Password after authenticating through Google.

============================================================ 36. CAPTCHA CONFIGURATION
============================================================

CAPTCHA should primarily protect:

- Public Reader Registration
- Author Account Request

Do not force CAPTCHA onto Google OAuth itself unless there is a clear security requirement.

The implementation must be configurable.

Preferred environment variables:

CAPTCHA_SITE_KEY=
CAPTCHA_SECRET_KEY=

Do not commit real credentials.

If no credentials are configured yet:

do not break the application.

Provide a clear development-mode behavior and document the configuration requirement.

============================================================ 37. FUTURE SECURITY ENHANCEMENTS
============================================================

The following are IMPORTANT but SHOULD NOT become blockers for the current MVP.

Prepare the architecture so these can be added later:

1. Two-Factor Authentication
2. Admin login audit trail
3. Login history
4. IP logging
5. User-Agent logging
6. Admin session timeout
7. Security notifications
8. Account linking
9. Email notifications

Do NOT build all of these now unless the existing application already contains the required architecture.

For the current phase:

Keep the implementation focused.

============================================================ 38. ADMIN SECURITY — FUTURE PHASE
============================================================

Future Admin security should support:

- 2FA
- Session timeout
- Login history
- Audit trail

Potential audit fields:

user_id
ip_address
user_agent
login_at
success
event_type

But do NOT create this system unless explicitly required by the current implementation task.

============================================================ 39. SESSION SECURITY
============================================================

Use Laravel's existing session security mechanisms.

Do NOT implement an aggressive session timeout for all users.

If a future timeout is implemented:

Apply stricter rules to:

/admin/\*

rather than the entire public website.

============================================================ 40. UI REFERENCES
============================================================

Before modifying authentication views:

Inspect the existing design reference files.

The project may contain:

design_references/

The Agent MUST inspect the actual available files and verify their extensions.

Possible authentication references include:

screen (7)
screen (8)
screen (9)
screen (10)
screen (11)

Do NOT assume the extension.

Use the actual files present in:

design_references/

The visual reference should be used to preserve:

- spacing
- typography
- card proportions
- colors
- icon placement
- responsive behavior
- visual hierarchy

Do NOT redesign authentication pages from scratch unless required.

============================================================ 41. AUTHENTICATION VIEWS
============================================================

Relevant views may include:

resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
resources/views/auth/forgot-password.blade.php
resources/views/auth/reset-password.blade.php

and/or:

resources/views/auth/...
resources/views/layouts/...
resources/views/components/...

DO NOT assume filenames.

Inspect the existing project first.

============================================================ 42. AUTHOR REQUEST UI
============================================================

Create or modify the appropriate view for:

"Request Account as Author"

The UI should contain:

Heading:
Request an Author Account

Explanation:

"Author accounts require administrative approval."

Fields:

Full Name
Institutional / Professional Email
University
Department / Field (optional if appropriate)

If the user is already authenticated as a reader:

- Prefill name.
- Prefill email.
- Do not allow changing the account email without an explicit account/email-change flow.

Button:

"Request Author Access"

Display:

"Your request will be reviewed by an administrator."

After submission:

status = pending

Do not automatically change:

role = reader

to:

role = author

============================================================ 43. AUTHOR REQUEST STATUS
============================================================

If a reader already has a pending request:

Do NOT allow duplicate requests.

Display:

"Your author account request is currently pending."

If rejected:

Allow the user to review the rejection status where appropriate.

If the user submits again:

follow the application's business rules.

Do not create unlimited duplicate requests.

============================================================ 44. ADMIN AUTHOR APPROVAL UI
============================================================

Admin should eventually have a page such as:

/admin/author-requests

or another existing admin route.

Before creating a new route:

inspect the existing admin architecture.

Admin should be able to:

- View pending requests
- View applicant details
- Approve
- Reject

Approval must be server-side.

============================================================ 45. REGISTRATION NAVIGATION
============================================================

Public registration should clearly distinguish:

"Create Reader Account"

and:

"Request Author Account"

Do NOT confuse users by presenting Author as a normal immediate registration role.

Recommended conceptual UI:

Create an Account

[ Continue with Google ]

OR

[ Register as Reader ]

[ Request Author Account ]

The exact visual implementation should follow the existing design references.

============================================================ 46. NO SUPPORT CONTACT PLACEHOLDERS
============================================================

This is an independent project.

At this stage, there may be:

- No IT helpdesk email
- No IT phone number
- No official support address

Therefore:

DO NOT invent:

- phone numbers
- email addresses
- university IT helpdesk contacts

If the design requires support information:

Use a neutral placeholder such as:

"Support contact will be available soon."

OR:

"Support information will be added later."

Keep the implementation easy to update later.

============================================================ 47. EXISTING AUTHENTICATION LOGIC
============================================================

IMPORTANT:

The application is already functional.

Do NOT replace the authentication system unless necessary.

Inspect whether the project uses:

- Laravel Breeze
- Laravel Fortify
- custom authentication
- Laravel UI
- another existing authentication architecture

Reuse the existing implementation.

Do not introduce a second authentication system.

============================================================ 48. MIGRATION SAFETY
============================================================

Before database changes:

1. Inspect the current users table.
2. Inspect current migrations.
3. Inspect existing role values.
4. Inspect existing authentication fields.
5. Determine whether password is currently nullable.
6. Determine whether provider/provider_id already exist.

Create incremental migrations only when necessary.

NEVER:

php artisan migrate:fresh

NEVER:

dropDatabase

NEVER:

truncate users

Preserve all existing users.

============================================================ 49. ROUTE SAFETY
============================================================

Before adding routes:

Run or inspect:

php artisan route:list

Check for existing:

- login
- register
- password reset
- admin routes
- author routes
- category routes

Do not create duplicate routes.

Use named routes where appropriate.

============================================================ 50. IMPLEMENTATION RULE
============================================================

This is an EXISTING PROJECT.

The implementation strategy MUST be:

AUDIT
↓
UNDERSTAND
↓
REUSE
↓
MODIFY MINIMALLY
↓
VERIFY

NOT:

REBUILD
↓
REPLACE
↓
REFACTOR EVERYTHING

Only change what is required by this specification.

============================================================ 51. AGENT EXECUTION PROCESS
============================================================

Before coding:

STEP 1 — PROJECT AUDIT

Inspect:

- Laravel version
- Authentication package
- User model
- Users migration
- Role implementation
- Auth routes
- Admin routes
- Existing middleware
- Existing auth views
- Existing article views
- Existing comments/rating functionality
- Existing Alpine.js setup
- Existing design references

STEP 2 — AUTHENTICATION ARCHITECTURE REPORT

Report:

- Current login architecture
- Current registration architecture
- Current role system
- Current admin authentication
- Current password handling
- Current Socialite status
- Existing routes
- Existing auth views
- Required migrations
- Required controllers
- Required middleware
- Files that will be modified
- Files that will be created

STEP 3 — IMPLEMENT

Implement only what is required.

STEP 4 — VERIFY

Check:

- Blade syntax
- Laravel routes
- Middleware
- Database migrations
- Validation
- Authentication flows
- Authorization
- Google callback handling
- Password-null behavior
- Author approval behavior

============================================================ 52. REQUIRED AUTHENTICATION TEST MATRIX
============================================================

The Agent MUST verify the following scenarios where possible.

---

## CASE 1 — Public Reader Local Registration

Register:

name
email
password

Expected:

role = reader
password = hashed password

Result:

Reader can log in using email/password.

---

## CASE 2 — Google New Reader

Google authentication with new email.

Expected:

role = reader
provider = google
provider_id = Google ID
password = NULL

Result:

Google login works.

Email/password login does NOT work.

---

## CASE 3 — Google Reader With Optional Password

Google user creates local password.

Expected:

password = hashed password

Result:

Google login works.

Email/password login works.

---

## CASE 4 — Existing Reader Login

Existing reader with local password.

Result:

Email/password login works.

---

## CASE 5 — Existing Author Login

Existing author with local password.

Result:

Email/password login works.

Author does NOT need to use Google.

---

## CASE 6 — Admin Login

Admin uses:

/admin/sign-in

Correct admin credentials:

→ Admin dashboard

---

## CASE 7 — Reader Attempts Admin Login

Reader credentials at:

/admin/sign-in

Expected:

Access denied.

Role must NOT change.

---

## CASE 8 — Author Attempts Admin Login

Author credentials at:

/admin/sign-in

Expected:

Access denied.

Role must NOT change.

---

## CASE 9 — Google Attempts Admin Authentication

Google login must NOT grant admin access.

Expected:

Denied / unsupported.

---

## CASE 10 — Reader Requests Author Account

Existing reader:

email = reader@example.com

Requests author access.

Expected:

One author request is created.

Email:

reader@example.com

Existing user remains:

role = reader

until approval.

---

## CASE 11 — Admin Approves Author

Admin approves request.

Expected:

Existing user:

reader → author

No duplicate user is created.

---

## CASE 12 — Admin Rejects Author

Admin rejects request.

Expected:

Existing user remains:

reader

Request:

status = rejected

---

## CASE 13 — Google-Only User Forgot Password

Google-only user:

password = NULL

Expected:

Do NOT send a fake/reset local password flow.

Explain:

"This account uses Google Sign-In."

---

## CASE 14 — Duplicate Author Request

User already has:

status = pending

Expected:

Do NOT create another duplicate pending request.

---

## CASE 15 — Privileged Email + Google

Existing:

admin@example.com
role = admin

Someone authenticates through Google using the same email.

Expected:

DO NOT automatically link Google to the admin account.

DO NOT grant admin access.

============================================================ 53. REGRESSION TESTING
============================================================

After implementation verify:

[ ] Homepage still loads.
[ ] Article pages still load.
[ ] Category pages still load.
[ ] Search still works.
[ ] Public navigation still works.
[ ] Comments still work.
[ ] Ratings still work if already implemented.
[ ] Reader authentication works.
[ ] Author authentication works.
[ ] Admin authentication works.
[ ] Admin dashboard remains protected.
[ ] Existing users are preserved.
[ ] Existing passwords remain valid.
[ ] No duplicate users are created.
[ ] No duplicate routes are created.
[ ] No duplicate author requests are created.
[ ] No Blade errors.
[ ] No PHP errors.
[ ] No JavaScript console errors.
[ ] No horizontal overflow on authentication pages.
[ ] Authentication pages remain responsive.

============================================================ 54. COMMAND SAFETY
============================================================

Allowed commands may include:

php artisan route:list
php artisan migrate
php artisan test
php artisan config:clear
php artisan cache:clear

Use project-appropriate commands.

DO NOT run destructive database commands.

NEVER run:

php artisan migrate:fresh

NEVER:

php artisan db:wipe

NEVER delete existing user data.

============================================================ 55. FUTURE FEATURES — DO NOT BLOCK CURRENT IMPLEMENTATION
============================================================

The following may be implemented later:

- Admin 2FA
- Author 2FA
- Login audit logs
- Admin session timeout
- Security notifications
- Email notifications
- Explicit OAuth account linking
- Advanced CAPTCHA
- Social providers other than Google

Do not implement these unless explicitly required.

Design the current architecture so they can be added later without major rewrites.

============================================================ 56. FINAL IMPLEMENTATION REPORT
============================================================

After implementation, provide a concise report containing:

1. Authentication architecture discovered
2. Files modified
3. Files created
4. Database migrations created
5. Routes added
6. Middleware added/modified
7. Google OAuth implementation status
8. Public registration implementation
9. Author request implementation
10. Admin sign-in implementation
11. Optional local password implementation
12. CAPTCHA implementation status
13. Tests performed
14. Any remaining configuration requirements
15. Any known limitations

The report MUST clearly state:

- Google Login is Reader-only.
- Apple Login was not implemented.
- Institutional SSO was not implemented.
- Admin login uses /admin/sign-in.
- Author accounts require approval.
- Google-only users cannot use email/password until they create a local password.
- Existing users were preserved.
- No destructive migration was performed.

Do NOT claim that Google OAuth is fully functional unless the required Google credentials are actually configured and the callback has been tested.

============================================================ 57. FINAL PRINCIPLE
============================================================

The final authentication model is:

PUBLIC:

Guest
↓
Register / Google
↓
Reader
↓
Comments / Ratings

READER → AUTHOR:

Reader
↓
Request Account as Author
↓
University + required information
↓
Pending
↓
Admin Review
↓
Approved
↓
Author

ADMIN:

/admin/sign-in
↓
Admin credentials
↓
Admin Dashboard

GOOGLE:

Google
↓
Reader ONLY
↓
password = NULL initially
↓
Optional Create Local Password
↓
Google + Email/Password login available

The system must never allow:

Public registration
↓
Admin

Google login
↓
Admin

Public registration
↓
Author immediately

Google email match
↓
Automatic privileged account linking

The implementation must prioritize:

SECURITY

- SIMPLICITY
- REUSABILITY
- MINIMAL CHANGES
- FUTURE EXTENSIBILITY
