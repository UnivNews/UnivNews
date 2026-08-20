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

        $existingUser = User::where('provider', 'google')->where('provider_id', $googleUser->getId())->first();

        if ($existingUser) {
            Auth::login($existingUser);
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Check if a user with this email already exists
        $userWithEmail = User::where('email', $googleUser->getEmail())->first();

        if ($userWithEmail) {
            if ($userWithEmail->isAdmin() || $userWithEmail->isAuthor()) {
                return redirect('/login')->withErrors(['google' => 'Cannot automatically link Google account to an existing privileged account.']);
            }
            
            // If they are a public user, we can link it
            $userWithEmail->update([
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
            ]);
            Auth::login($userWithEmail);
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Create a new reader (public)
        $newUser = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'provider' => 'google',
            'provider_id' => $googleUser->getId(),
            'role' => User::ROLE_PUBLIC,
            'password' => null,
        ]);

        Auth::login($newUser);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
