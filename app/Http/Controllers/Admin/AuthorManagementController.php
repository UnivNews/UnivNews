<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthorManagementController extends Controller
{
    public function index(): View
    {
        $pendingAuthors = User::with('university')
            ->where('author_status', User::STATUS_PENDING)
            ->latest()
            ->get();

        $activeAuthors = User::with('university')
            ->withCount('articles')
            ->whereIn('role', [User::ROLE_AUTHOR, User::ROLE_ADMIN])
            ->latest()
            ->paginate(15);

        return view('admin.authors.index', compact('pendingAuthors', 'activeAuthors'));
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update([
            'role' => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
        ]);

        return back()->with('success', "Author privileges approved for {$user->name}.");
    }

    public function reject(User $user): RedirectResponse
    {
        $user->update([
            'author_status' => User::STATUS_REJECTED,
        ]);

        return back()->with('success', "Author application for {$user->name} has been rejected.");
    }

    public function suspend(User $user): RedirectResponse
    {
        $user->update([
            'author_status' => User::STATUS_SUSPENDED,
        ]);

        return back()->with('success', "Author account for {$user->name} has been suspended.");
    }
}
