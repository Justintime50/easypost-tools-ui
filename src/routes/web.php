<?php

use App\Http\Middleware\ApiKey;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Includes custom logic (logout url) - must come before "Auth::routes();"
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Auth::routes();

Route::middleware(Authenticate::class)->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/app', [App\Http\Controllers\HomeController::class, 'index'])->name('app');
    Route::get('/account', [App\Http\Controllers\HomeController::class, 'account'])->name('account');
    // Named this to avoid conflict with the EasyPost API key resources
    Route::post('/update-api-key', [App\Http\Controllers\UserController::class, 'updateApiKey']);
});

// Decrypt and use the API key from the user's account for the following routes
Route::middleware([Authenticate::class, ApiKey::class])->group(function () {
    // Addresses
    Route::post('/addresses', [App\Http\Controllers\AddressController::class, 'createAddress']);
    Route::get('/addresses/{id}', [App\Http\Controllers\AddressController::class, 'retrieveAddress']);
    Route::get('/addresses', [App\Http\Controllers\AddressController::class, 'retrieveAddresses']);

    // Carriers
    Route::get('/carriers/{id}', [App\Http\Controllers\CarrierController::class, 'retrieveCarrier']);
    Route::get('/carriers', [App\Http\Controllers\CarrierController::class, 'retrieveCarriers']);

    // Insurance
    Route::post('/insurances', [App\Http\Controllers\InsuranceController::class, 'createInsurance']);
    Route::get('/insurances', [App\Http\Controllers\InsuranceController::class, 'retrieveInsurances']);

    // Parcels
    Route::get('/parcels', [App\Http\Controllers\ParcelController::class, 'retrieveParcels']);
    Route::get('/parcels/{id}', [App\Http\Controllers\ParcelController::class, 'retrieveParcel']);
    Route::post('/parcels', [App\Http\Controllers\ParcelController::class, 'createParcel']);

    // Refunds
    Route::get('/refunds', [App\Http\Controllers\RefundController::class, 'retrieveRefunds']);
    Route::get('/refunds/{id}', [App\Http\Controllers\RefundController::class, 'retrieveRefund']);

    // Search
    Route::post('/search', [App\Http\Controllers\SearchController::class, 'searchRecord']);

    // Shipments
    Route::post('/shipments', [App\Http\Controllers\ShipmentController::class, 'createShipment']);
    Route::get('/shipments/{id}', [App\Http\Controllers\ShipmentController::class, 'retrieveShipment']);
    Route::get('/shipments', [App\Http\Controllers\ShipmentController::class, 'retrieveShipments']);
    Route::post('/shipments/{id}/buy', [App\Http\Controllers\ShipmentController::class, 'buyShipment']);
    Route::post('/shipments/{id}/refund', [App\Http\Controllers\ShipmentController::class, 'createRefund']);
    Route::post('/shipments/stamp', [App\Http\Controllers\ShipmentController::class, 'buyStamp']);
    Route::post('/shipments/{id}/qr-codes', [App\Http\Controllers\ShipmentController::class, 'generateQrCodes']);

    // Tracking
    Route::post('/trackers', [App\Http\Controllers\TrackerController::class, 'createTracker']);
    Route::get('/trackers/{id}', [App\Http\Controllers\TrackerController::class, 'retrieveTracker']);
    Route::get('/trackers', [App\Http\Controllers\TrackerController::class, 'retrieveTrackers']);
});
