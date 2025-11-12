<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerValidationController;
use App\Http\Controllers\Api\SearchController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/password/reset-link', [AuthController::class, 'resetPassword']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);

        // Search Routes
        Route::get('/customers/{account_meter}', [SearchController::class, 'customers']);
        Route::get('/feeders', [SearchController::class, 'feeder11']);
        Route::get('/transformers/feeder/{feeder_id}', [SearchController::class, 'transformersByFeeder']);

        // Customer Validation
        Route::resource('enumerated-customers', CustomerValidationController::class)->only(
            ['index', 'show', 'store']
        );
        Route::post('/enumerated-customers/approve', [CustomerValidationController::class, 'approve']);
        Route::post('/enumerated-customers/reject', [CustomerValidationController::class, 'reject']);
    });
});
