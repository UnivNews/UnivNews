# University News Portal (UnivNews)

A modern, authoritative, and secure news portal designed for university-related journalism.

**UnivNews** is an independent university-themed news portal project built with Laravel. The application provides a public news platform together with a Content Management System (CMS) for approved authors and administrators.

The system uses a role-based authentication and authorization architecture that separates:

- Public Readers
- Authors
- Administrators

> **Important:** UnivNews is an independent project and is **not an official university authentication system**. It does not depend on institutional SSO, SAML, Shibboleth, Azure AD, or other university identity providers.

---

# 📌 Project Overview

UnivNews is designed to provide a structured digital news platform for university-related content such as:

- News
- Events
- Research
- Achievements
- Campus information
- Announcements
- Other editorial content

The platform consists of two major areas:

### Public Website

The public-facing website allows visitors to:

- Browse published news
- Search for articles
- Browse news categories
- Read individual articles
- View article information
- Comment on articles when authenticated
- Rate articles when the feature is enabled
- Create a public Reader account
- Sign in using Google

### CMS / Administration

The CMS allows authorized users to:

- Create and manage articles
- Manage categories
- Manage tags
- Manage article publishing
- Manage authors
- Review author account requests
- Access administrative functionality according to their role

---

# 🚀 Tech Stack

| Technology | Purpose |
|---|---|
| **Laravel** | Backend framework |
| **PHP** | Backend programming language |
| **PostgreSQL** | Relational database |
| **Blade** | Server-side frontend templating |
| **Tailwind CSS** | UI styling |
| **Alpine.js** | Lightweight frontend interactivity |
| **Vite** | Frontend asset bundling |
| **Laravel Socialite** | Google OAuth authentication |
| **RBAC** | Role-Based Access Control |

The exact Laravel authentication implementation should follow the existing project architecture. Existing authentication functionality should be reused rather than replaced unnecessarily.

---

# 📋 Prerequisites

Make sure the development environment includes:

- PHP 8.2 or higher
- Composer
- Node.js
- NPM
- PostgreSQL
- Git

The exact PHP and Laravel versions should follow the versions specified by the project's dependency files.

Check:

```text
composer.json
package.json
```

before installing or upgrading dependencies.

---

# 🛠️ Installation

## 1. Clone the Repository

Clone the project:

```bash
git clone <repository-url>
```

Enter the project directory:

```bash
cd UnivNews-cedar
```

If the repository has already been cloned:

```bash
cd UnivNews-cedar
```

---

## 2. Install PHP Dependencies

Run:

```bash
composer install
```

---

## 3. Install Frontend Dependencies

Run:

```bash
npm install
```

---

## 4. Configure Environment

Create the local environment file.

### Linux / macOS / Git Bash

```bash
cp .env.example .env
```

### Windows PowerShell

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

---

# 🗄️ PostgreSQL Configuration

UnivNews uses PostgreSQL as its primary database.

Configure the database section in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=univnews
DB_USERNAME=postgres
DB_PASSWORD=
```

Replace the values with the credentials configured in the local PostgreSQL installation.

Create the PostgreSQL database before running the migrations.

---

# 🔄 Database Migration

Run:

```bash
php artisan migrate
```

If the project contains seeders and initial data is required:

```bash
php artisan migrate --seed
```

The actual database schema must always follow the current Laravel migration files.

Do not assume that a table exists simply because it is mentioned in older documentation.

---

# 🖼️ Storage Configuration

If the application uses Laravel's public storage system for featured images or uploaded files, create the storage link:

```bash
php artisan storage:link
```

---

# ▶️ Running the Application

For local development, two terminal windows are typically required.

### Terminal 1 — Laravel

```bash
php artisan serve
```

### Terminal 2 — Vite

```bash
npm run dev
```

Open the URL displayed by Laravel Artisan, usually:

```text
http://127.0.0.1:8000
```

---

# 🔐 Authentication Architecture

UnivNews uses three primary account roles:

```text
reader
author
admin
```

An unauthenticated visitor is considered a **Guest** and is not stored as a database role.

The general authentication architecture is:

```text
Guest
  │
  ├── Register
  │      ↓
  │    Reader
  │
  └── Continue with Google
         ↓
       Reader
```

Reader-to-author flow:

```text
Reader
   │
   └── Request Account as Author
              ↓
           Pending
              ↓
         Admin Review
          ┌────┴────┐
          ↓         ↓
       Approve    Reject
          ↓         ↓
       Author     Reader
```

Admin authentication is isolated:

```text
/admin/sign-in
       ↓
     Admin
       ↓
Admin Dashboard
```

---

# 👤 Account Roles

## Guest

A Guest is an unauthenticated visitor.

Guests can:

- Browse public pages
- Read published articles
- Browse categories
- Search public content

Guests cannot:

- Comment
- Rate content where authentication is required
- Access author CMS functionality
- Access admin functionality

---

## Reader

A Reader is a normal public account.

Readers can:

- Read published articles
- Browse public content
- Comment on articles where enabled
- Rate articles where enabled
- Manage their own account
- Sign in using email/password
- Sign in using Google if the account is linked to Google

Readers cannot:

- Access author CMS functionality
- Access admin functionality
- Assign themselves the `author` or `admin` role

---

## Author

An Author is a Reader whose request to become an author has been approved by an Administrator.

Authors can perform author-related CMS actions according to the application's authorization rules.

Authors cannot:

- Access admin-only functionality
- Promote themselves to Admin
- Approve other author requests unless explicitly authorized

---

## Admin

An Admin is a privileged account responsible for administrative functionality.

Admins may:

- Access the admin dashboard
- Manage articles
- Manage categories
- Manage tags
- Manage users where permitted
- Review author account requests
- Approve or reject author requests
- Perform administrative operations

Admin access must always be enforced server-side.

---

# 🔑 Public Login

The primary public authentication page is:

```text
/login
```

The public login page supports:

- Email + Password
- Google OAuth

It is intended for:

- Readers
- Authors

The public login page must NOT provide:

- Admin login
- Role selection
- Apple Sign-In
- Institutional SSO

---

# 👨💼 Admin Login

Administrators use a dedicated authentication path:

```text
/admin/sign-in
```

This route is intentionally separated from the public login system.

The Admin login page should contain:

- Email
- Password
- Sign In

The Admin login page must NOT provide:

- Google Login
- Apple Login
- Institutional SSO
- Public Registration
- Author Registration
- Role Selection

Only accounts with:

```text
role = admin
```

may access the Admin Dashboard.

---

# 🛡️ Admin Access Protection

Administrative routes must be protected server-side.

For example:

```text
Reader → /admin/dashboard → Unauthorized
Author → /admin/dashboard → Unauthorized
Admin  → /admin/dashboard → Allowed
```

Hiding admin links from the frontend is not sufficient.

Use the project's existing:

- Middleware
- Gates
- Policies
- Role authorization

where appropriate.

---

# 🌐 Google OAuth

Google OAuth is used to provide a convenient authentication method for public users.

The implementation uses:

**Laravel Socialite**

Google authentication is conceptually handled through:

```text
/auth/google/redirect
/auth/google/callback
```

The exact route names should follow the actual Laravel route configuration.

Verify routes with:

```bash
php artisan route:list
```

---

# 👥 Google Account Rules

Google authentication is intended for **Reader accounts**.

A new Google-authenticated user must receive:

```text
role = reader
```

Google authentication must NEVER automatically create:

```text
author
admin
```

accounts.

---

# 🔒 Google-Only Accounts

A newly created Google account may initially have:

```text
provider = google
provider_id = <Google Provider ID>
password = NULL
role = reader
```

This is intentional.

A Google-only user can authenticate through:

```text
Google → Allowed
```

but cannot authenticate through:

```text
Email + Password → Not available
```

until a local password has been explicitly created.

The system must NOT:

- Generate a fake password
- Store an empty plaintext password
- Guess a password
- Automatically assign a local password

---

# 🔑 Optional Local Password for Google Users

Google users may optionally create a local password.

This provides an additional authentication method without removing Google authentication.

Initial state:

```text
Google Login       ✅
Email + Password   ❌
```

After creating a local password:

```text
Google Login       ✅
Email + Password   ✅
```

The local password must always be securely hashed using Laravel's password hashing mechanism.

A Google user may be shown a non-blocking notification such as:

> Your account currently uses Google Sign-In. You can optionally create a local password to sign in with your email and password.

Available actions may include:

```text
Create Local Password
```

and:

```text
Maybe Later
```

Creating a local password is optional.

---

# 🔗 Google Account Linking Safety

The system must NOT automatically connect Google authentication to an existing privileged account solely because the email addresses match.

For example:

```text
Existing Account
email = admin@example.com
role = admin
```

A person signing in with Google using:

```text
admin@example.com
```

must NOT automatically receive access to the Admin account.

Do not automatically link Google authentication to:

- Admin accounts
- Author accounts
- Other privileged accounts

unless an explicit and secure account-linking flow is implemented in the future.

---

# ❌ Authentication Methods Not Used

The project intentionally does NOT use:

- Apple Sign-In
- Institutional SSO
- SAML
- Shibboleth
- Azure AD / Microsoft institutional authentication

The project is independently developed and does not have access to an official university identity provider.

Google is currently the only supported social authentication provider.

---

# 📝 Public Registration

Public registration creates **Reader accounts only**.

The registration page should contain:

- Full Name
- Email
- Password
- Confirm Password
- Terms of Service agreement
- Privacy Policy agreement
- CAPTCHA / anti-bot protection

A public user must NOT be able to select:

```text
admin
author
```

during registration.

The resulting account must be:

```text
role = reader
```

---

# ✍️ Request Account as Author

Author accounts are not created through normal public registration.

A Reader who wants to become an Author must use:

```text
Request Account as Author
```

The expected flow is:

```text
Reader
   ↓
Request Account as Author
   ↓
Submit Information
   ↓
Pending
   ↓
Admin Review
   ↓
Approve / Reject
```

---

# 👤 Existing Reader Requesting Author Access

If the user is already authenticated as a Reader, the application should reuse the existing account.

Example:

```text
Name:
John Doe

Email:
john@example.com

Role:
reader
```

The Author Request should use the same account and email.

Additional information may include:

- University
- Department
- Field of Study
- Other relevant information

After submitting:

```text
User Role:
reader

Request Status:
pending
```

The user's role must NOT immediately change to `author`.

---

# ✅ Author Approval

When an Admin approves the request:

```text
reader → author
```

The existing user account is updated.

A second account must NOT be created.

Example:

```text
Before approval:

john@example.com
role = reader

After approval:

john@example.com
role = author
```

---

# ❌ Author Rejection

If an Admin rejects the request:

```text
Request:
rejected
```

The existing user remains:

```text
role = reader
```

The system must not grant author permissions.

---

# 🚫 Duplicate Author Requests

If a user already has a pending author request, the application should prevent the creation of another identical pending request.

Example:

```text
john@example.com
request = pending
```

The user should see a message such as:

> Your author account request is currently pending review.

---

# 🧑💼 Admin Author Request Management

Administrators should be able to review author requests from the Admin CMS.

The interface may provide:

- Applicant Name
- Email
- University
- Department
- Request Date
- Status
- Approve
- Reject

The exact route and UI structure should follow the existing Admin architecture.

All actions must be server-side authorized.

---

# 🧾 CAPTCHA / Anti-Bot Protection

CAPTCHA is intended primarily for:

- Public Reader Registration
- Author Account Requests

Possible solutions:

- Cloudflare Turnstile
- Google reCAPTCHA

Credentials must be stored in environment variables.

Example:

```env
CAPTCHA_SITE_KEY=
CAPTCHA_SECRET_KEY=
```

Never hardcode production credentials.

If CAPTCHA credentials have not yet been configured, the implementation should remain configurable for local development.

Do not claim that CAPTCHA is active until its credentials and verification have been configured and tested.

---

# 🔄 Password Reset

Users who have a local password can use the normal Laravel password reset functionality.

For Google-only accounts:

```text
password = NULL
```

the application should not pretend that a local password exists.

The user should be informed that the account currently uses Google Sign-In.

Recommended flow:

```text
Google-only user
       ↓
Continue with Google
       ↓
Authenticated
       ↓
Create Local Password (optional)
```

---

# 📜 Terms of Service & Privacy

Public registration should require acceptance of:

- Terms of Service
- Privacy Policy

The checkbox must be validated server-side.

Users must not be able to register without accepting the required agreements.

If official legal documents are not yet available, do not invent legal claims.

The links/placeholders should remain easy to update later.

---

# 🎨 Design System

The public website and authentication interfaces follow the established UnivNews visual system.

## Colors

| Purpose | Color |
|---|---|
| Primary Navy | `#00081e` |
| Crimson | `#b71032` |
| Background | `#fcf8f9` |
| Surface | `#ffffff` |
| Border | `#c5c6cf` |
| Text | `#1b1b1c` |

---

## Typography

### Headlines

```text
Montserrat
```

### Body Content

```text
Source Serif 4
```

### Navigation / Buttons / Labels

```text
Work Sans
```

---

## Shapes

The project follows a sharp editorial / newspaper-inspired visual language.

Primary:

- Cards
- Inputs
- Buttons
- Containers
- Navigation elements

should use:

```css
border-radius: 0;
```

Circular shapes are reserved primarily for:

- Avatars
- Profile icons
- Appropriate circular status/icon elements

Avoid excessive rounded UI elements.

---

## Borders and Shadows

Prefer:

```text
1px borders
```

using:

```text
#c5c6cf
```

Avoid heavy box shadows.

Hierarchy should primarily be created through:

- Typography
- Borders
- Color blocking
- Spacing
- Layout

---

# 🖼️ Design References

All visual design references are stored in:

```text
design_references/
```

The actual file extensions may be `.png`, `.jpg`, or other supported image formats.

Developers and AI coding agents should inspect the directory before modifying UI.

Authentication references may include designs for:

- Login
- Password Reset
- Password Reset Confirmation
- Account Request
- Create New Password

The implementation should reproduce the established visual hierarchy rather than introducing an unrelated design system.

---

# 🏠 Public Website Navigation

The current public navigation consists of:

```text
Home
News & Event
Achievements
```

`News & Event` provides access to available news categories.

The category menu may use:

- Hover interaction on desktop
- Click/tap interaction on touch devices

The category dropdown should follow the established design system:

```text
Background: #ffffff
Border: 1px #c5c6cf
Border radius: 0
```

Category data should preferably come from the application's existing category model/query.

---

# 📰 Content Structure

Core content entities include:

- Users
- Categories
- Articles
- Tags
- Article Tags
- Author Account Requests where applicable

The exact database schema must follow the current migrations.

---

# 🗃️ Core Article Data

Articles may contain fields such as:

- ID
- Title
- Slug
- Excerpt
- Content
- Featured Image
- Status
- Published At
- Views Count
- Author/User ID
- Category ID

The exact implementation should follow the current database migrations and models.

---

# 🧪 Testing

Before considering an authentication update complete, verify at minimum:

### Public Reader Registration

```text
[ ] User can register
[ ] Account is created as reader
[ ] Password is hashed
[ ] Terms/Privacy validation works
[ ] CAPTCHA behavior is correct
```

### Google Login

```text
[ ] New Google user becomes reader
[ ] provider is stored correctly
[ ] provider_id is stored correctly
[ ] password initially remains NULL
[ ] Google login works
[ ] Email/password login does not work before local password creation
```

### Local Password

```text
[ ] Google user can optionally create a local password
[ ] Password is hashed
[ ] Email/password login works afterward
[ ] Google login continues to work
```

### Author Request

```text
[ ] Reader can request author access
[ ] Existing reader account is reused
[ ] Email remains associated with the existing account
[ ] Request starts as pending
[ ] Duplicate pending requests are prevented
```

### Admin Approval

```text
[ ] Admin can view requests
[ ] Admin can approve
[ ] Existing reader becomes author
[ ] No duplicate user is created
```

### Admin Rejection

```text
[ ] Admin can reject
[ ] Request becomes rejected
[ ] Existing reader remains reader
```

### Admin Authentication

```text
[ ] /admin/sign-in exists
[ ] Admin can authenticate
[ ] Reader cannot access admin dashboard
[ ] Author cannot access admin dashboard
[ ] Google cannot grant admin access
```

---

# 🛡️ Security Principles

The application follows these principles:

1. Roles are assigned server-side.
2. Users cannot assign themselves privileged roles.
3. Google OAuth cannot grant admin privileges.
4. Google OAuth cannot automatically grant author privileges.
5. Privileged accounts are not automatically linked to Google by email matching.
6. Passwords are never stored in plaintext.
7. Existing user data must be preserved.
8. CSRF protection must remain enabled.
9. Server-side validation is required.
10. Protected routes must use authorization middleware/policies.
11. OAuth credentials must remain outside the repository.
12. CAPTCHA secrets must remain outside the repository.

---

# 🔐 Future Security Enhancements

The following features may be implemented in future iterations:

- Admin 2FA
- Author 2FA
- Login audit trail
- Login history
- IP address logging
- User-Agent logging
- Admin session timeout
- Security notifications
- Explicit Google account linking
- Advanced CAPTCHA protection
- Email notifications

These features should not block the current MVP unless explicitly required.

---

# 📞 Support Information

This is an independent project.

Official IT/helpdesk contact information is not currently available.

Do NOT invent:

- University IT phone numbers
- University IT email addresses
- Fake support addresses
- Fake institutional contacts

If support information is required in the UI before official contact information is available, use a neutral placeholder that can be replaced later.

Example:

```text
Support contact information will be available soon.
```

---

# 🔧 Environment Variables

A typical `.env` configuration may contain:

```env
APP_NAME=UnivNews
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=univnews
DB_USERNAME=postgres
DB_PASSWORD=

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=

CAPTCHA_SITE_KEY=
CAPTCHA_SECRET_KEY=
```

Only variables actually required by the current implementation should be configured.

Never commit real credentials.

---

# 🔒 Environment Security

Never commit the following to Git:

```text
.env
```

or any file containing:

- Database passwords
- OAuth client secrets
- CAPTCHA secrets
- API keys
- Application secrets

Use:

```text
.env.example
```

for safe placeholders.

---

# 📁 Project Structure

The exact project structure may evolve.

A typical Laravel structure includes:

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/

database/
├── migrations/
├── seeders/
└── factories/

resources/
├── views/
│   ├── auth/
│   ├── layouts/
│   ├── components/
│   └── ...
├── css/
└── js/

routes/
├── web.php
└── auth.php

design_references/

.env
.env.example
composer.json
package.json
vite.config.js
```

Always inspect the actual repository before assuming a file exists.

---

# 🧹 Development Safety

This is an existing project.

Before modifying functionality:

1. Inspect the current implementation.
2. Understand existing routes.
3. Understand existing models.
4. Understand existing migrations.
5. Understand existing authentication.
6. Reuse existing components where possible.
7. Make incremental changes.
8. Test affected functionality.
9. Avoid unrelated refactoring.

Do not rebuild working systems unnecessarily.

---

# ⚠️ Database Safety

Never run destructive commands against a database containing project data.

Do NOT run:

```bash
php artisan migrate:fresh
```

or:

```bash
php artisan db:wipe
```

unless the developer explicitly intends to destroy the database and has confirmed that doing so is safe.

Do not:

- Drop the users table
- Truncate users
- Delete existing articles
- Delete existing accounts
- Reset production data

when implementing normal project changes.

---

# 🧰 Useful Artisan Commands

Check routes:

```bash
php artisan route:list
```

Run migrations:

```bash
php artisan migrate
```

Run migrations with seeders:

```bash
php artisan migrate --seed
```

Clear Laravel caches:

```bash
php artisan optimize:clear
```

Create storage link:

```bash
php artisan storage:link
```

Run tests:

```bash
php artisan test
```

---

# 🌐 Google OAuth Setup

Google OAuth requires credentials configured through Google Cloud.

The application expects environment variables similar to:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
```

The configured redirect URI must match the redirect URI registered in the Google OAuth application.

Google OAuth should only be considered fully configured after:

1. Client ID is configured.
2. Client Secret is configured.
3. Redirect URI is configured.
4. Google OAuth consent configuration is available.
5. `/auth/google/redirect` works.
6. `/auth/google/callback` works.
7. A real Google authentication test succeeds.

Never commit the client secret to Git.

---

# 📊 Authentication Summary

## Public

```text
Guest
 │
 ├── Register
 │      ↓
 │    Reader
 │
 └── Continue with Google
        ↓
      Reader
```

## Reader → Author

```text
Reader
 │
 └── Request Author Account
          ↓
       Pending
          ↓
     Admin Review
       ┌──┴──┐
       ↓     ↓
    Approve Reject
       ↓     ↓
    Author Reader
```

## Admin

```text
/admin/sign-in
       ↓
     Admin
       ↓
Admin Dashboard
```

## Google-Only Account

```text
Google Login
      ↓
    Reader
      ↓
password = NULL
      │
      ├── Google Login       ✅
      │
      └── Email/Password    ❌
               │
               │ Optional
               ↓
      Create Local Password
               ↓
      Google Login           ✅
      Email/Password         ✅
```

---

# 🚧 Current Development Status

UnivNews is an actively developed project.

Some external services may require configuration before production use:

- Google OAuth credentials
- CAPTCHA credentials
- Production database
- Production application URL
- Future support/contact information

The absence of these credentials should not be treated as a code failure during local development.

---

# 📄 Related Specifications

Detailed authentication and onboarding requirements are documented in:

```text
SUPPLEMENTAL_AUTH_SOCIAL.MD
```

This document contains the detailed specifications for:

- Public authentication
- Google OAuth
- Reader registration
- Author account requests
- Admin authentication
- Optional local passwords
- Authentication security
- Authorization behavior

The current project implementation and migrations remain the final source of truth for what is actually available in the codebase.

When documentation and implementation differ, inspect the current code, migrations, routes, and configuration before making changes.

---

# 🎯 Final Authentication Model

The intended UnivNews authentication model is:

```text
                    UNIVNEWS
                       │
            ┌──────────┴──────────┐
            │                     │
        PUBLIC                  ADMIN
            │                     │
      ┌─────┴─────┐        /admin/sign-in
      │           │                │
   Register    Google              ↓
      │           │              ADMIN
      └─────┬─────┘
            ↓
         READER
            │
            │ Request Author Account
            ↓
         PENDING
            │
            ↓
      ADMIN REVIEW
        ┌───┴───┐
        ↓       ↓
     APPROVE  REJECT
        ↓       ↓
     AUTHOR   READER
```

The system must NEVER allow:

```text
Public Registration
        ↓
      Admin
```

or:

```text
Public Registration
        ↓
     Author
```

without approval.

It must also NEVER allow:

```text
Google Login
     ↓
    Admin
```

or:

```text
Google Login
     ↓
   Author
```

automatically.

The intended authentication philosophy is:

> **Simple for public users, controlled for authors, isolated for administrators, and secure by default.**
