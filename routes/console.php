<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

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

// Dashboard (temporary)
Route::get('/admin/dashboard', function () {
    return 'Admin Dashboard';
})->name('admin.dashboard')->middleware('auth');

Route::get('/umkm/dashboard', function () {
    return 'UMKM Dashboard';
})->name('umkm.dashboard')->middleware('auth');

// UMKM Register Form (akan dibuat next step)
Route::get('/umkm/register', function () {
    return 'Form Registrasi UMKM (next step)';
})->name('umkm.register.form')->middleware('auth');
