<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Includes custom logic (logout url) - must come before "Auth::routes();"
Route::post('logout', 'Auth\LoginController@logout');
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/app', 'HomeController@index')->name('app');
    Route::get('/account', 'HomeController@account')->name('account');
    // Named this to avoid conflict with the EasyPost API key resources
    Route::post('/update-api-key', 'UserController@updateApiKey');
});

// Decrypt and use the API key from the user's account for the following routes
Route::middleware(['auth', 'ApiKey'])->group(function () {
    // Addresses
    Route::post('/addresses', 'AddressController@createAddress');
    Route::get('/addresses/{id}', 'AddressController@retrieveAddress');
    Route::get('/addresses', 'AddressController@retrieveAddresses');

    // Carriers
    Route::get('/carriers/{id}', 'CarrierController@retrieveCarrier');
    Route::get('/carriers', 'CarrierController@retrieveCarriers');

    // Insurance
    Route::post('/insurances', 'InsuranceController@createInsurance');
    Route::get('/insurances', 'InsuranceController@retrieveInsurances');

    // Parcels
    Route::get('/parcels', 'ParcelController@retrieveParcels');
    Route::get('/parcels/{id}', 'ParcelController@retrieveParcel');
    Route::post('/parcels', 'ParcelController@createParcel');

    // Refunds
    Route::get('/refunds', 'RefundController@retrieveRefunds');
    Route::get('/refunds/{id}', 'RefundController@retrieveRefund');

    // Search
    Route::post('/search', 'SearchController@searchRecord');

    // Shipments
    Route::post('/shipments', 'ShipmentController@createShipment');
    Route::get('/shipments/{id}', 'ShipmentController@retrieveShipment');
    Route::get('/shipments', 'ShipmentController@retrieveShipments');
    Route::post('/shipments/{id}/buy', 'ShipmentController@buyShipment');
    Route::post('/shipments/{id}/refund', 'ShipmentController@createRefund');
    Route::post('/shipments/stamp', 'ShipmentController@buyStamp');

    // Tracking
    Route::post('/trackers', 'TrackerController@createTracker');
    Route::get('/trackers/{id}', 'TrackerController@retrieveTracker');
    Route::get('/trackers', 'TrackerController@retrieveTrackers');
});
