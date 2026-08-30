<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Boost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = Auth::guard('admin')->user();

        // ── Activity Log ──────────────────────────────────────────────
        // Recent articles that need/had review (pending, approved, rejected)
        $recentArticles = Article::with(['user', 'category'])
            ->whereIn('status', [
                Article::STATUS_PENDING_REVIEW,
                Article::STATUS_PUBLISHED,
                Article::STATUS_REJECTED,
                Article::STATUS_AWAITING_PAYMENT,
            ])
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->map(function ($article) {
                $type = match ($article->status) {
                    Article::STATUS_PENDING_REVIEW   => 'Pending Review',
                    Article::STATUS_PUBLISHED         => 'Approved & Published',
                    Article::STATUS_REJECTED          => 'Rejected',
                    Article::STATUS_AWAITING_PAYMENT  => 'Awaiting Payment',
                    default                           => ucfirst($article->status),
                };

                return [
                    'time'   => $article->updated_at,
                    'type'   => $type,
                    'icon'   => match ($article->status) {
                        Article::STATUS_PENDING_REVIEW  => 'clock',
                        Article::STATUS_PUBLISHED        => 'check',
                        Article::STATUS_REJECTED         => 'x',
                        Article::STATUS_AWAITING_PAYMENT => 'credit-card',
                        default                          => 'document',
                    },
                    'color'  => match ($article->status) {
                        Article::STATUS_PENDING_REVIEW  => 'amber',
                        Article::STATUS_PUBLISHED        => 'green',
                        Article::STATUS_REJECTED         => 'red',
                        Article::STATUS_AWAITING_PAYMENT => 'blue',
                        default                          => 'gray',
                    },
                    'detail' => '"' . \Illuminate\Support\Str::limit($article->title, 45) . '" by ' . ($article->user->preferred_name ?? $article->user->name),
                ];
            });

        // Expired boosts
        $expiredBoosts = Boost::with(['article', 'user'])
            ->where('status', 'active')
            ->where('end_date', '<', now()->toDateString())
            ->latest('end_date')
            ->take(5)
            ->get()
            ->map(function ($boost) {
                return [
                    'time'   => $boost->end_date,
                    'type'   => 'Boost Expired',
                    'icon'   => 'lightning',
                    'color'  => 'purple',
                    'detail' => '"' . \Illuminate\Support\Str::limit($boost->article->title ?? 'Unknown', 45) . '" — ' . $boost->duration_days . ' days boost ended',
                ];
            });

        // Merge and sort by time descending
        $activityLog = $recentArticles->concat($expiredBoosts)
            ->sortByDesc('time')
            ->take(10)
            ->values();

        return view('admin.settings', compact('activityLog'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'preferred_name'  => 'nullable|string|max:255',
            'email'           => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number'    => 'nullable|string|max:50',
            'social_instagram' => 'nullable|string|max:255',
            'social_twitter'   => 'nullable|string|max:255',
            'social_threads'   => 'nullable|string|max:255',
            'social_linkedin'  => 'nullable|string|max:255',
        ]);

        // Build social links array
        $socialLinks = array_filter([
            'instagram' => $request->input('social_instagram'),
            'twitter'   => $request->input('social_twitter'),
            'threads'   => $request->input('social_threads'),
            'linkedin'  => $request->input('social_linkedin'),
        ]);

        $user->update([
            'name'           => $validated['name'],
            'preferred_name' => $validated['preferred_name'],
            'email'          => $validated['email'],
            'phone_number'   => $validated['phone_number'],
            'social_links'   => !empty($socialLinks) ? $socialLinks : null,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password:admin',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::guard('admin')->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('password_success', 'Password updated successfully.');
    }
}
