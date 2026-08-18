<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\Author as Author;

// 1. Public Portal Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/category/{category:slug}', [PublicController::class, 'category'])->name('category');
Route::get('/research', [PublicController::class, 'research'])->name('research');
Route::get('/article/{article:slug}', [PublicController::class, 'article'])->name('article');
Route::get('/search', [PublicController::class, 'search'])->name('search');

// 2. Authenticated General Routes
Route::middleware(['auth'])->group(function () {
    
    // Generic Dashboard fallback route
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isAuthor()) {
            return redirect()->route('author.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Standard Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Apply to Become an Author
    Route::get('/apply-author', [Author\ApplyController::class, 'create'])->name('author.apply');
    Route::post('/apply-author', [Author\ApplyController::class, 'store'])->name('author.apply.store');

    // 3. Author Area Routes
    Route::prefix('author')->middleware(['role:author'])->name('author.')->group(function () {
        Route::get('/dashboard', [Author\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('articles', Author\ArticleController::class)->except(['show']);
        Route::get('/profile', [Author\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [Author\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/settings', [Author\ProfileController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Author\ProfileController::class, 'update'])->name('settings.update');
    });

    // 4. Admin Area Routes
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Article Review Workflow
        Route::get('/articles/{article}/review', [Admin\ReviewController::class, 'show'])->name('articles.review');
        Route::post('/articles/{article}/approve', [Admin\ReviewController::class, 'approve'])->name('articles.approve');
        Route::post('/articles/{article}/reject', [Admin\ReviewController::class, 'reject'])->name('articles.reject');

        // Articles Resource
        Route::resource('articles', Admin\ArticleController::class)->except(['show']);

        // Author Management
        Route::get('/authors', [Admin\AuthorManagementController::class, 'index'])->name('authors.index');
        Route::post('/authors/{user}/approve', [Admin\AuthorManagementController::class, 'approve'])->name('authors.approve');
        Route::post('/authors/{user}/reject', [Admin\AuthorManagementController::class, 'reject'])->name('authors.reject');
        Route::post('/authors/{user}/suspend', [Admin\AuthorManagementController::class, 'suspend'])->name('authors.suspend');

        // University Management
        Route::resource('universities', Admin\UniversityController::class)->only(['index', 'store', 'destroy']);

        // Profile & Settings
        Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/settings', [Admin\ProfileController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Admin\ProfileController::class, 'update'])->name('settings.update');
    });
});

// 5. Auth Routes (Breeze)
require __DIR__.'/auth.php';

// 6. Account Request Routes (Guest)
Route::get('/account-request', function () {
    return view('auth.account-request');
})->middleware('guest')->name('account-request');

Route::post('/account-request', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'department' => 'required|string',
    ]);
    
    return back()->with('status', 'Your account request has been submitted successfully.');
})->middleware('guest')->name('account-request.store');
