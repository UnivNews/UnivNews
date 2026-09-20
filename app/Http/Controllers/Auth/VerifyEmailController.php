<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            $redirectUrl = $user->isAdmin()
                ? route('admin.settings.edit', absolute: false) . '?verified=1'
                : ($user->isAuthor()
                    ? route('author.settings.edit', absolute: false) . '?verified=1'
                    : route('dashboard', absolute: false) . '?verified=1');
            return redirect()->intended($redirectUrl);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $redirectUrl = $user->isAdmin()
            ? route('admin.settings.edit', absolute: false) . '?verified=1'
            : ($user->isAuthor()
                ? route('author.settings.edit', absolute: false) . '?verified=1'
                : route('dashboard', absolute: false) . '?verified=1');

        return redirect()->intended($redirectUrl);
    }
}
