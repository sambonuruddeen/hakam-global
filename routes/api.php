<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ShipmentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/password/reset-link', [AuthController::class, 'resetPassword']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
    
        // Shipment Resource Routes
        Route::resource('shipments', ShipmentController::class);
        Route::get('/shipments/status/{status}', [ShipmentController::class, 'byStatus']);
        Route::get('/shipments-statistics', [ShipmentController::class, 'statistics']);
        Route::get('/shipments-latest/{limit?}', [ShipmentController::class, 'latest']);
    });
});
