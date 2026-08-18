<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $universities = University::orderBy('name')->get();
        return view('author.settings', compact('universities'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'preferred_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:50',
            'university_id' => 'nullable|exists:universities,id',
            'department' => 'nullable|string|max:255',
            'author_bio' => 'nullable|string|max:2000',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
