<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Mail\AdminNewApplicationNotification;
use App\Mail\AuthorApplicationReceived;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ApplyController extends Controller
{
    public function create(): View
    {
        $user = auth()->user();

        $universities = University::orderBy('name')->get();
        return view('author.apply', compact('universities', 'user'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Already an active author — redirect to dashboard
        if ($user->author_status === User::STATUS_APPROVED) {
            return redirect()->route('author.dashboard')->with('info', 'You are already an approved author.');
        }

        // Already pending — no need to re-submit
        if ($user->author_status === User::STATUS_PENDING) {
            return redirect()->route('author.apply')->with('info', 'Your application is already under review.');
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id',
            'department'    => 'required|string|max:255',
            'page_name'     => 'nullable|string|max:255',
            'phone_number'  => 'nullable|string|max:50',
            'author_bio'    => 'required|string|min:50|max:2000',
        ], [
            'author_bio.min'  => 'Bio / statement harus minimal 50 karakter.',
            'author_bio.required' => 'Bio / statement wajib diisi.',
            'university_id.required' => 'Universitas wajib dipilih.',
            'department.required' => 'Fakultas / Departemen wajib diisi.',
        ]);

        $user->update([
            'name'              => $validated['name'],
            'university_id'     => $validated['university_id'],
            'department'        => $validated['department'],
            'page_name'         => $validated['page_name'] ?? $user->page_name,
            'phone_number'      => $validated['phone_number'] ?? $user->phone_number,
            'author_bio'        => $validated['author_bio'],
            'author_status'     => User::STATUS_PENDING,
            'author_applied_at' => now(),
        ]);

        // Send confirmation email to the applicant
        try {
            Mail::to($user->email)->send(new AuthorApplicationReceived($user->fresh()));
        } catch (\Exception $e) {
            // Log but don't block — mail driver is 'log' in local anyway
        }

        // Notify all admins
        try {
            $admins = User::where('role', User::ROLE_ADMIN)->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new AdminNewApplicationNotification($user->fresh()));
            }
        } catch (\Exception $e) {
            // Log but don't block
        }

        return redirect()->route('author.apply.confirmation');
    }

    public function confirmation(): View
    {
        $user = auth()->user();
        // If they haven't actually applied, redirect to form
        if ($user->author_status !== User::STATUS_PENDING) {
            return redirect()->route('author.apply');
        }
        return view('author.apply-confirmation', compact('user'));
    }
}
