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

         // Ride Routes
        Route::get('/packages/rides/{ride}/book', [SuperAdminController::class, 'showBookingForm'])->name('packages.rides.book');
        Route::post('/packages/rides/book/store', [SuperAdminController::class, 'storeRideBooking'])->name('packages.rides.book.store');
        Route::post('/packages/rides/validate-promo', [SuperAdminController::class, 'validatePromoCode'])->name('packages.rides.validate_promo');

        // Rides Routes (with full CRUD)
        Route::get('/packages/rides', [SuperAdminController::class, 'rides'])->name('packages.rides.rides');
        Route::get('/packages/rides/create', [SuperAdminController::class, 'createRideCategory'])->name('packages.rides_create');
        Route::post('/packages/rides/store', [SuperAdminController::class, 'storeRideCategory'])->name('packages.rides_store');
        Route::get('/packages/rides/{id}/edit', [SuperAdminController::class, 'editRideCategory'])->name('packages.rides_edit');
        Route::put('/packages/rides/{id}', [SuperAdminController::class, 'updateRideCategory'])->name('packages.rides_update');
        Route::delete('/packages/rides/{id}', [SuperAdminController::class, 'deleteRideCategory'])->name('packages.rides_delete');

        // Ride Cities Routes
        Route::get('/packages/rides/cities', [SuperAdminController::class, 'rideCities'])->name('packages.rides.cities');
        Route::post('/packages/rides/cities/store', [SuperAdminController::class, 'rideCitiesStore'])->name('packages.rides_cities_store');
        Route::delete('/packages/rides/cities/{city}', [SuperAdminController::class, 'rideCitiesDelete'])->name('packages.rides_cities_delete');

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


        // Promo Code Routes
        Route::get('/promo-codes', [SuperAdminController::class, 'promoCodes'])->name('promo_codes');
        Route::get('/promo-codes/create', [SuperAdminController::class, 'createPromoCode'])->name('promo_codes.create');
        Route::post('/promo-codes', [SuperAdminController::class, 'storePromoCode'])->name('promo_codes.store');
        Route::get('/promo-codes/{id}', [SuperAdminController::class, 'viewPromoCode'])->name('promo_codes.view');
        Route::get('/promo-codes/{id}/edit', [SuperAdminController::class, 'editPromoCode'])->name('promo_codes.edit');
        Route::put('/promo-codes/{id}', [SuperAdminController::class, 'updatePromoCode'])->name('promo_codes.update');
        Route::delete('/promo-codes/{id}', [SuperAdminController::class, 'deletePromoCode'])->name('promo_codes.delete');

        // Booking management

        // Air taxi Booking Routes
        Route::get('/bookings/air-taxi-bookings', [SuperAdminController::class, 'showAirTaxiBookings'])->name('bookings.air_taxi.bookings');
        Route::get('/bookings/air-taxi-bookings/{id}/view', [SuperAdminController::class, 'viewAirTaxiBooking'])->name('bookings.air_taxi.view');
        Route::get('/bookings/air-taxi-bookings/{id}/edit', [SuperAdminController::class, 'editAirTaxiBooking'])->name('bookings.air_taxi.edit');
        Route::put('/bookings/air-taxi-bookings/{id}', [SuperAdminController::class, 'updateAirTaxiBooking'])->name('bookings.air_taxi.update');
        Route::patch('/bookings/air-taxi-bookings/{id}/status', [SuperAdminController::class, 'updateAirTaxiBookingStatus'])->name('bookings.air_taxi.status');
        Route::delete('/bookings/air-taxi-bookings/{id}', [SuperAdminController::class, 'deleteAirTaxiBooking'])->name('bookings.air_taxi.delete');

        // Ride Booking Routes
        Route::get('/bookings/rides', [SuperAdminController::class, 'showRideBookings'])->name('bookings.rides.bookings');
        Route::get('/bookings/rides/{id}', [SuperAdminController::class, 'showRideBooking'])->name('bookings.rides.view');
        Route::get('/bookings/rides/{id}/edit', [SuperAdminController::class, 'editRideBooking'])->name('bookings.rides.edit');
        Route::put('/bookings/rides/{id}', [SuperAdminController::class, 'updateRideBooking'])->name('bookings.rides.update');
        Route::delete('/bookings/rides/{id}', [SuperAdminController::class, 'destroyRideBooking'])->name('bookings.rides.destroy');

        // Tour Booking Routes

        Route::get('/bookings/tours', [SuperAdminController::class, 'showTourBookings'])->name('bookings.tours.bookings');

        // Heli Tours Payment Routes
        Route::get('/payments', [SuperAdminController::class, 'showHeliPaymentPage'])->name('payments');
        Route::get('/payments/{id}/view', [SuperAdminController::class, 'viewPaymentDetails'])->name('payments.view');
        Route::get('/payments/{id}/edit', [SuperAdminController::class, 'editPaymentDetails'])->name('payments.edit');
        Route::put('/payments/{id}', [SuperAdminController::class, 'updatePaymentDetails'])->name('payments.update');
        Route::delete('/payments/{id}', [SuperAdminController::class, 'deletePaymentRecord'])->name('payments.delete');

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
