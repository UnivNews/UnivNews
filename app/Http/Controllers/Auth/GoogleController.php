<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            \Log::error('Google Auth Failed: ' . $e->getMessage());
            return redirect('/login')->withErrors(['google' => 'Failed to authenticate with Google.']);
        }

        // Case A: User is already authenticated (linking from profile page)
        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            $currentUser = Auth::guard('admin')->user() ?: Auth::guard('web')->user();
            $redirectRoute = $currentUser->isAdmin()
                ? route('admin.settings.edit')
                : ($currentUser->isAuthor() ? route('author.settings.edit') : route('profile.edit'));

            // Check if this Google account is already linked to another user
            $linkedUser = User::where('provider', 'google')
                ->where('provider_id', $googleUser->getId())
                ->where('id', '!=', $currentUser->id)
                ->first();

            if ($linkedUser) {
                return redirect($redirectRoute)->with('error', 'This Google account is already linked to another user.');
            }

            $currentUser->update([
                'provider'          => 'google',
                'provider_id'       => $googleUser->getId(),
                'email_verified_at' => $currentUser->email_verified_at ?? now(),
            ]);

            return redirect($redirectRoute)->with('status', 'google-linked');
        }

        // Case B: User is a guest logging in with Google
        $existingUser = User::where('provider', 'google')->where('provider_id', $googleUser->getId())->first();

        if ($existingUser) {
            if (!$existingUser->email_verified_at) {
                $existingUser->update(['email_verified_at' => now()]);
            }
            Auth::login($existingUser);
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Check if a user with this email already exists
        $userWithEmail = User::where('email', $googleUser->getEmail())->first();

        if ($userWithEmail) {
            if ($userWithEmail->isAdmin() || $userWithEmail->isAuthor()) {
                return redirect('/login')->withErrors(['google' => 'Cannot automatically link Google account to an existing privileged account.']);
            }
            
            // If they are a public user, link and verify
            $userWithEmail->update([
                'provider'          => 'google',
                'provider_id'       => $googleUser->getId(),
                'email_verified_at' => $userWithEmail->email_verified_at ?? now(),
            ]);
            Auth::login($userWithEmail);
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Create a new reader (public)
        $newUser = User::create([
            'name'              => $googleUser->getName(),
            'email'             => $googleUser->getEmail(),
            'provider'          => 'google',
            'provider_id'       => $googleUser->getId(),
            'role'              => User::ROLE_PUBLIC,
            'password'          => null,
            'email_verified_at' => now(),
        ]);

        Auth::login($newUser);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
