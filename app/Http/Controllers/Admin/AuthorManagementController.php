<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AuthorApplicationApproved;
use App\Mail\AuthorApplicationRejected;
use App\Models\Article;
use App\Models\AuthorApprovalToken;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthorManagementController extends Controller
{
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'authors');
        if (!in_array($activeTab, ['authors', 'readers'])) {
            $activeTab = 'authors';
        }

        $pendingAuthorsCount = User::where('author_status', User::STATUS_PENDING)->count();
        $activeAuthorsCount = User::whereIn('role', [User::ROLE_AUTHOR, User::ROLE_ADMIN])->count();
        $readersCount = User::where('role', User::ROLE_PUBLIC)->count();

        // Data for Authors tab
        $pendingAuthors = collect();
        $activeAuthors = null;
        if ($activeTab === 'authors') {
            $pendingAuthors = User::with('university')
                ->where('author_status', User::STATUS_PENDING)
                ->latest('author_applied_at')
                ->get();

            $activeAuthors = User::with(['university', 'approvalToken'])
                ->withCount('articles')
                ->whereIn('role', [User::ROLE_AUTHOR, User::ROLE_ADMIN])
                ->latest()
                ->paginate(15)
                ->withQueryString();
        }

        // Data for Readers tab
        $readers = null;
        $universities = University::orderBy('name')->get();
        $totalReadersCount = $readersCount;
        $activeReadersCount = User::where('role', User::ROLE_PUBLIC)->has('readingHistories')->count();
        $newReadersCount = User::where('role', User::ROLE_PUBLIC)->where('created_at', '>=', now()->subDays(30))->count();

        if ($activeTab === 'readers') {
            $readersQuery = User::with(['university', 'readingHistories.article.category', 'readingHistories.article.user'])
                ->withCount(['comments', 'likes', 'readingHistories'])
                ->where('role', User::ROLE_PUBLIC);

            if ($search = trim((string) $request->input('q'))) {
                $readersQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%");
                });
            }

            if ($uniId = $request->input('university_id')) {
                $readersQuery->where('university_id', $uniId);
            }

            if ($status = $request->input('status')) {
                if ($status === 'suspended') {
                    $readersQuery->where('author_status', User::STATUS_SUSPENDED);
                } elseif ($status === 'active') {
                    $readersQuery->where('author_status', '!=', User::STATUS_SUSPENDED);
                }
            }

            $readers = $readersQuery->latest()->paginate(12)->withQueryString();
        }

        return view('admin.authors.index', compact(
            'activeTab',
            'pendingAuthors',
            'activeAuthors',
            'readers',
            'universities',
            'pendingAuthorsCount',
            'activeAuthorsCount',
            'readersCount',
            'totalReadersCount',
            'activeReadersCount',
            'newReadersCount'
        ));
    }

    public function approve(User $user): RedirectResponse
    {
        // Set role and status
        $user->update([
            'role'          => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
        ]);

        // Delete any existing token for this user then create a fresh one (48h)
        $user->approvalToken()->delete();
        $token = AuthorApprovalToken::create([
            'user_id'    => $user->id,
            'token'      => Str::random(64),
            'expires_at' => now()->addHours(48),
        ]);

        // Send approval email with set-password link
        try {
            Mail::to($user->email)->send(new AuthorApplicationApproved($user, $token));
        } catch (\Exception $e) {
            // Log but don't block
        }

        return back()->with('success', "Aplikasi author untuk {$user->name} telah disetujui. Email aktivasi telah dikirim.");
    }

    public function reject(User $user, Request $request): RedirectResponse
    {
        $reason = $request->input('reason');

        $user->update([
            'role'                     => User::ROLE_PUBLIC,
            'author_status'            => User::STATUS_REJECTED,
            'author_rejection_reason'  => $reason,
        ]);

        // Send rejection email
        try {
            Mail::to($user->email)->send(new AuthorApplicationRejected($user, $reason));
        } catch (\Exception $e) {
            // Log but don't block
        }

        return back()->with('success', "Aplikasi author untuk {$user->name} telah ditolak.");
    }

    public function suspend(User $user): RedirectResponse
    {
        $user->update([
            'author_status' => User::STATUS_SUSPENDED,
        ]);

        return back()->with('success', "Akun author {$user->name} telah ditangguhkan.");
    }

    /**
     * Cancel author approval for a user who has not yet completed password creation & verification.
     */
    public function cancelApproval(User $user): RedirectResponse
    {
        if (!$user->approvalToken) {
            return back()->with('error', 'Cannot cancel approval: This user has already completed account setup or does not have a pending approval token.');
        }

        // Delete the approval token
        $user->approvalToken()->delete();

        // Revert user to reader role and reset author status
        $user->update([
            'role'                     => User::ROLE_PUBLIC,
            'author_status'            => User::STATUS_NONE,
            'author_rejection_reason'  => 'Approval cancelled by administrator before password setup.',
        ]);

        return back()->with('success', "Approval for {$user->name} has been cancelled. The user has been reverted to Reader.");
    }

    /**
     * Delete an author/user completely, reassigning all their articles to the admin.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $adminId  = auth()->id();

        DB::transaction(function () use ($user, $adminId) {
            // 1. Reassign all articles to the currently logged-in Admin (single batch query)
            Article::where('user_id', $user->id)->update(['user_id' => $adminId]);

            // 2. Delete all related records — use query builder (not nullsafe) for reliability
            $user->approvalToken()->delete();
            $user->boosts()->delete();
            $user->boostPayments()->delete();
            $user->readingHistories()->delete();

            // 3. Delete the user account
            $user->delete();
        });

        return back()->with('success', "Akun \"{$userName}\" telah dihapus secara permanen. Seluruh artikelnya telah dialihkan kepemilikannya ke akun Admin.");
    }

    /**
     * Suspend or unsuspend a reader user.
     */
    public function toggleReaderStatus(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        if ($user->author_status === User::STATUS_SUSPENDED) {
            $user->update(['author_status' => User::STATUS_NONE]);
            $msg = "Akun pembaca \"{$user->name}\" berhasil diaktifkan kembali.";
        } else {
            $user->update(['author_status' => User::STATUS_SUSPENDED]);
            $msg = "Akun pembaca \"{$user->name}\" telah ditangguhkan.";
        }

        return back()->with('success', $msg);
    }
}

