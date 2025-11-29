<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShipmentItemsController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarOrdersController;
use App\Http\Controllers\CarShipmentsController;
use App\Http\Controllers\MakesController;
use App\Http\Controllers\CarModelsController;
use App\Http\Controllers\CarListingsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\ExternalItemsController;
use App\Http\Controllers\PaymentTransactionsController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/password/reset-link', [AuthController::class, 'resetPassword']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {

        // User Logout
        Route::post('/logout', [AuthController::class, 'logout']);

        // ===== CATALOG MANAGEMENT =====
        // Vendors (dealers, suppliers, etc.)
        Route::resource('vendors', VendorsController::class);

        // Makes (manufacturers)
        // Route::resource('makes', MakesController::class);

        // Car Models (by make)
        // Route::resource('car-models', CarModelsController::class);

        // Car Listings (inventory with per-car pricing)
        Route::resource('car-listings', CarListingsController::class);

        // External Items (non-platform cars for shipment)
        Route::resource('external-items', ExternalItemsController::class);

        // ===== ORDERS & PURCHASES =====
        // Car Orders (customer purchases from platform)
        Route::resource('car-orders', CarOrdersController::class);
        Route::get('/car-orders/status/{status}', [CarOrdersController::class, 'byStatus']);
        Route::get('/users/{userId}/car-orders', [CarOrdersController::class, 'byUser']);

        // ===== SHIPMENTS =====
        // Shipments (logistics container tracking)
        Route::resource('shipments', ShipmentController::class);
        Route::get('/shipments/status/{status}', [ShipmentController::class, 'byStatus']);
        Route::get('/shipments-statistics', [ShipmentController::class, 'statistics']);
        Route::get('/shipments-latest/{limit?}', [ShipmentController::class, 'latest']);

        // Shipment Items (polymorphic: supports both CarOrder and ExternalItem)
        // Route::post('/shipments/{shipment}/items', [ShipmentItemsController::class, 'store']);
        // Route::get('/shipments/{shipment}/items', [ShipmentItemsController::class, 'shipmentItems']);
        // Route::patch('/shipments/{shipment}/items/{shipmentItem}', [ShipmentItemsController::class, 'update']);
        // Route::delete('/shipments/{shipment}/items/{shipmentItem}', [ShipmentItemsController::class, 'destroy']);

        // ===== PAYMENTS =====
        // Payment Transactions (separate tracking for car purchases and shipping)
        Route::resource('payment-transactions', PaymentTransactionsController::class);
        Route::get('/payment-transactions/pending', [PaymentTransactionsController::class, 'pending']);
        Route::get('/payment-transactions/completed', [PaymentTransactionsController::class, 'completed']);

        // ===== LEGACY ROUTES =====
        
        // Route::resource('cars', CarController::class);

        // CarShipments pivot routes (legacy - use shipment-items instead)
        Route::resource('car-shipments', CarShipmentsController::class)->only(['index','store','show','destroy']);
        Route::post('/car-shipments/bulk-assign', [CarShipmentsController::class, 'bulkAssign']);
        Route::get('/shipment-cars/{shipmentId}', [CarShipmentsController::class, 'shipmentCars']);
        Route::get('/order-shipments/{carOrderId}', [CarShipmentsController::class, 'orderShipments']);
    });
});
