<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user('admin') ?: $request->user();
        if (!$user) {
            return back()->with('error', 'Unauthenticated.');
        }

        if ($user->hasVerifiedEmail()) {
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.settings.edit', absolute: false));
            }
            if ($user->isAuthor()) {
                return redirect()->intended(route('author.settings.edit', absolute: false));
            }
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Only allow sending verification emails to valid Google/Gmail accounts
        if (!\App\Models\User::isGoogleEmail($user->email) && !$user->isGoogleLinked()) {
            return back()->with('error', 'Google account not found: A valid Google (Gmail) email address is required to receive verification emails.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
