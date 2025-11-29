<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/enumerations', function () {
    return Inertia::render('Enumerations');
})->middleware(['auth', 'verified'])->name('enumerations');

Route::get('/map', function () {
    return Inertia::render('MapPage');
})->middleware(['auth', 'verified'])->name('map');

Route::get('/asset', function () {
    return Inertia::render('Assets/Assets');
})->middleware(['auth', 'verified'])->name('asset');

// Add Assets Route
Route::get('/add-assets', function () {
    return Inertia::render('Assets/AddAssets');
})->middleware(['auth', 'verified'])->name('add-assets');

Route::get('/reports', function () {
    return Inertia::render('Reports');
})->middleware(['auth', 'verified'])->name('reports');

Route::get('/users', function () {
    return Inertia::render('AccessControl/UsersList');
})->middleware(['auth', 'verified'])->name('users');

Route::get('/roles', function () {
    return Inertia::render('RolePermission/Index');
})->middleware(['auth', 'verified'])->name('roles');


// Route::get('/customers', function () {
//     return Inertia::render('Customers');
// })->middleware(['auth', 'verified'])->name('customers');

// Car Makes Route

// Car Models Route

// Shipping Companies Route

// Shipping Routes - Request, Schedule and allocate a container



require __DIR__.'/settings.php';
