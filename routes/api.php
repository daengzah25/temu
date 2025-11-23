<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CompanyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API V1
Route::prefix('v1')->group(function () {

    // UMKM Endpoints
    Route::prefix('umkm')->group(function () {
        Route::get('/nearby', [CompanyController::class, 'nearby']);
        Route::get('/{slug}', [CompanyController::class, 'show']);
    });

});
