<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HuggingFaceService;
use App\Http\Controllers\AiPromotionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Welcome
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Role Selection
Route::middleware('auth')->group(function () {
    Route::get('/select-role', [RoleController::class, 'showSelectRole'])->name('select.role');
    Route::post('/select-role', [RoleController::class, 'updateRole'])->name('role.update');
});

// UMKM Routes
Route::middleware(['auth'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/register', [UmkmController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [UmkmController::class, 'register'])->name('register');
    Route::get('/waiting', [UmkmController::class, 'waiting'])->name('waiting');
    Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('dashboard');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/companies', [AdminController::class, 'companies'])->name('companies');
    Route::get('/company/{id}', [AdminController::class, 'showCompany'])->name('company.show');
    Route::post('/company/{id}/approve', [AdminController::class, 'approve'])->name('company.approve');
    Route::post('/company/{id}/reject', [AdminController::class, 'reject'])->name('company.reject');

    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.updateRole');
    Route::put('/users/{id}/status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});

// Visitor Routes (Public)
Route::name('visitor.')->group(function () {
    Route::get('/visitor/home', [VisitorController::class, 'home'])->name('home');
    Route::get('/nearby', [VisitorController::class, 'nearby'])->name('nearby');
    Route::get('/umkm/{slug}', [VisitorController::class, 'show'])->name('company.show');
});

// Bookmark Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::post('/bookmark/{companyId}/toggle', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
});

// Product Routes (UMKM only)
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::post('/products/{id}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle');
    Route::delete('/products/image/{id}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
});

// AI Promotion Routes (UMKM only)
Route::middleware(['auth'])->prefix('ai-promotion')->name('ai-promotion.')->group(function () {
    Route::get('/', [AiPromotionController::class, 'index'])->name('index');
    Route::post('/generate', [AiPromotionController::class, 'generate'])->name('generate');
    Route::post('/store', [AiPromotionController::class, 'store'])->name('store');
    Route::delete('/{id}', [AiPromotionController::class, 'destroy'])->name('destroy');
});


// UMKM Routes
Route::middleware(['auth'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/register', [UmkmController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [UmkmController::class, 'register'])->name('register');
    Route::get('/waiting', [UmkmController::class, 'waiting'])->name('waiting');
    Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('dashboard');

    // Edit Profile
    Route::get('/profile/edit', [UmkmController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UmkmController::class, 'updateProfile'])->name('profile.update');
});

// Profile Route (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});
