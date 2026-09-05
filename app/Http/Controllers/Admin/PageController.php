<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function editAbout(): View
    {
        $page = SitePage::firstOrCreate(
            ['slug' => 'about-us'],
            ['title' => 'About Us']
        );

        return view('admin.pages.about', compact('page'));
    }

    public function updateAbout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
        ]);

        $page = SitePage::where('slug', 'about-us')->firstOrFail();
        $page->update($validated);

        return back()->with('success', 'About Us page content updated successfully.');
    }

    public function editPrivacy(): View
    {
        $page = SitePage::firstOrCreate(
            ['slug' => 'privacy-policy'],
            ['title' => 'Privacy Policy']
        );

        return view('admin.pages.privacy', compact('page'));
    }

    public function updatePrivacy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $page = SitePage::where('slug', 'privacy-policy')->firstOrFail();
        $page->update($validated);

        return back()->with('success', 'Privacy Policy updated successfully.');
    }
}
