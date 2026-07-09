<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;

// ──────────────── Landing Page ────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ──────────────── Guest Routes ────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// ──────────────── Authenticated Routes ────────────────

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile',         [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',         [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ── Admin Only: User Management ──
    Route::middleware('can:user.view')->group(function () {
        Route::resource('users', UserManagementController::class)->except(['show']);
    });

    // ── Admin Only: Branch Management ──
    Route::middleware('can:branch.view')->group(function () {
        Route::resource('branches', \App\Http\Controllers\BranchController::class)->except(['show', 'create', 'edit']);
    });

    // ── Owner: Inventory ──
    Route::middleware('can:product.view')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('stock-movements', StockMovementController::class)->only(['index', 'create', 'store']);
    });

    // ── Owner: POS ──
    Route::middleware('can:pos.access')->group(function () {
        Route::get('/pos',           [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('/pos/receipt/{order}', [PosController::class, 'receipt'])->name('pos.receipt');
    });

    // ── Owner: Reports ──
    Route::middleware('can:report.view')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});
