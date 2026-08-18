<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/category/{category:slug}', [PublicController::class, 'category'])->name('category');
Route::get('/research', [PublicController::class, 'research'])->name('research');
Route::get('/article/{article:slug}', [PublicController::class, 'article'])->name('article');
Route::get('/search', [PublicController::class, 'search'])->name('search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Admin Articles Routes (Requires Editor or Admin Role)
    Route::middleware('role:admin,editor')->prefix('admin/articles')->name('admin.articles')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'articles']);
        Route::get('/create', [App\Http\Controllers\AdminController::class, 'createArticle'])->name('.create');
        Route::post('/', [App\Http\Controllers\AdminController::class, 'storeArticle'])->name('.store');
        Route::get('/{article}/edit', [App\Http\Controllers\AdminController::class, 'editArticle'])->name('.edit');
        Route::put('/{article}', [App\Http\Controllers\AdminController::class, 'updateArticle'])->name('.update');
        Route::delete('/{article}', [App\Http\Controllers\AdminController::class, 'deleteArticle'])->name('.delete');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Account Request Routes (UI placeholder)
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
