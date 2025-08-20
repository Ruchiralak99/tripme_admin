<?php

use App\Http\Controllers\Affiliate\AffiliateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Super_Admin\SuperAdminController;
use App\Http\Controllers\Vendor\VendorController;

// Authentication Routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (authenticated users only)
Route::middleware('auth')->group(function () {


    Route::prefix('super_admin')->name('super_admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/user-management', [SuperAdminController::class, 'userManagement'])->name('user_management');
        Route::get('/user-management/create', [SuperAdminController::class, 'createUser'])->name('user_create');
        Route::post('/user-management/store', [SuperAdminController::class, 'storeUser'])->name('user_store');
        Route::get('/user-management/{id}', [SuperAdminController::class, 'userShow'])->name('user_show');
        Route::get('/user-management/{id}/edit', [SuperAdminController::class, 'editUser'])->name('user_edit');
        Route::put('/user-management/{id}', [SuperAdminController::class, 'updateUser'])->name('user_update');
        Route::delete('/user-management/{id}', [SuperAdminController::class, 'deleteUser'])->name('user_delete');
        Route::patch('/user-management/{id}/toggle-status', [SuperAdminController::class, 'toggleUserStatus'])->name('user_toggle_status');

        // Package Management Routes
        Route::get('/packages', [SuperAdminController::class, 'showPackages'])->name('packages');

        // Air Taxi Routes
        Route::get('/packages/air-taxi', [SuperAdminController::class, 'airTaxi'])->name('packages.air_taxi');
        Route::post('/packages/air-taxi/book', [SuperAdminController::class, 'storeAirTaxiBooking'])->name('packages.air_taxi.book');
        Route::get('/packages/air-taxi/aircraft/{id}', [SuperAdminController::class, 'getAircraftDetails'])->name('packages.air_taxi.aircraft_details');

        // Rides Routes (with full CRUD)
        Route::get('/packages/rides', [SuperAdminController::class, 'rides'])->name('packages.rides');
        Route::get('/packages/rides/create', [SuperAdminController::class, 'createRideCategory'])->name('packages.rides_create');
        Route::post('/packages/rides/store', [SuperAdminController::class, 'storeRideCategory'])->name('packages.rides_store');
        Route::get('/packages/rides/{id}/edit', [SuperAdminController::class, 'editRideCategory'])->name('packages.rides_edit');
        Route::put('/packages/rides/{id}', [SuperAdminController::class, 'updateRideCategory'])->name('packages.rides_update');
        Route::delete('/packages/rides/{id}', [SuperAdminController::class, 'deleteRideCategory'])->name('packages.rides_delete');

        // Tours Routes
        Route::get('/packages/tours', [SuperAdminController::class, 'tours'])->name('packages.tours');

        //Air Craft Routes
        Route::get('/aircrafts', [SuperAdminController::class, 'showAirCrafts'])->name('aircrafts');
        Route::get('/aircrafts/create', [SuperAdminController::class, 'createAircraft'])->name('aircrafts.create');
        Route::post('/aircrafts/store', [SuperAdminController::class, 'storeAircraft'])->name('aircrafts.store');
        Route::get('/aircrafts/{id}/edit', [SuperAdminController::class, 'editAircraft'])->name('aircrafts.edit');
        Route::put('/aircrafts/{id}', [SuperAdminController::class, 'updateAircraft'])->name('aircrafts.update');
        Route::get('/aircrafts/{id}/view', [SuperAdminController::class, 'viewAircraft'])->name('aircrafts.view');
        Route::delete('/aircrafts/{id}', [SuperAdminController::class, 'deleteAircraft'])->name('aircrafts.delete');
    });


    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
    // You can add more vendor routes here

    });


    Route::prefix('affiliate')->name('affiliate.')->group(function () {
        Route::get('/dashboard', [AffiliateController::class, 'dashboard'])->name('dashboard');
        // You can add more affiliate routes here
    });





});
