<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UniversityController extends Controller
{
    public function index(): View
    {
        $universities = University::withCount('users')->latest()->get();
        return view('admin.universities.index', compact('universities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:universities,name',
            'abbreviation' => 'nullable|string|max:20',
        ]);

        University::create($validated);

        return redirect()->route('admin.universities.index')->with('success', 'University added successfully.');
    }

    public function destroy(University $university): RedirectResponse
    {
        $university->delete();
        return redirect()->route('admin.universities.index')->with('success', 'University removed successfully.');
    }
}
