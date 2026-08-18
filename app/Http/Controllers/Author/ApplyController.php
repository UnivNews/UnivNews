<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplyController extends Controller
{
    public function create(): View
    {
        $universities = University::orderBy('name')->get();
        return view('author.apply', compact('universities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->author_status === User::STATUS_APPROVED) {
            return redirect()->route('author.dashboard')->with('info', 'You are already an approved author.');
        }

        $validated = $request->validate([
            'university_id' => 'required|exists:universities,id',
            'department' => 'required|string|max:255',
            'page_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:50',
            'author_bio' => 'required|string|max:2000',
        ]);

        $validated['author_status'] = User::STATUS_PENDING;

        $user->update($validated);

        return back()->with('success', 'Your application to become a contributing author has been submitted for review.');
    }
}
