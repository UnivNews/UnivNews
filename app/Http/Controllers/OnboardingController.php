<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Mark onboarding as completed for the current user.
     *
     * Modes:
     *  - Dashboard mode (no 'page' param) → sets has_completed_onboarding = true
     *  - Page mode ('page' param present)  → appends page tour ID to completed_page_tours[]
     */
    public function complete(Request $request)
    {
        // Resolve current user from whichever guard is active
        $user = Auth::guard('admin')->check()
            ? Auth::guard('admin')->user()
            : $request->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $status = $request->input('status', 'completed'); // 'completed' or 'skipped'
        $pageTourId = $request->input('page');            // e.g. 'author.articles.create', or null

        if ($pageTourId) {
            // Per-page tour mode: append to completed_page_tours array
            $tours = $user->completed_page_tours ?? [];
            if (! in_array($pageTourId, $tours, true)) {
                $tours[] = $pageTourId;
            }
            $user->update(['completed_page_tours' => $tours]);
        } else {
            // Dashboard tour mode: mark global onboarding complete
            $user->update([
                'has_completed_onboarding' => true,
                'onboarding_completed_at'  => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'status'  => $status,
            'page'    => $pageTourId,
        ]);
    }
}
