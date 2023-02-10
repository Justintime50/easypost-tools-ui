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

Route::post('logout', 'Auth\LoginController@logout'); // Includes custom logic (logout url) - must come before "Auth::routes();"
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/app', 'HomeController@index')->name('app');
    Route::get('/account', 'HomeController@account')->name('account');
    Route::post('/update-api-key', 'UserController@updateApiKey');
});

// Decrypt and use the API key from the user's account on POST routes
Route::middleware(['auth', 'ApiKey'])->group(function () {
    // Search
    Route::post('/search', 'SearchController@searchRecord');

    // Addresses
    Route::post('/create-address', 'AddressController@createAddress');
    Route::get('/address/{id}', 'AddressController@retrieveAddress');
    Route::get('/addresses', 'AddressController@retrieveAddresses');

    // Parcels
    Route::post('/create-parcel', 'ParcelController@createParcel');

    // Shipments
    Route::post('/create-shipment', 'ShipmentController@createShipment');
    Route::get('/shipment/{id}', 'ShipmentController@retrieveShipment');
    Route::get('/shipments', 'ShipmentController@retrieveShipments');
    Route::post('/buy-shipment', 'ShipmentController@buyShipment');
    Route::post('/buy-stamp', 'ShipmentController@buyStamp');
    Route::post('/create-refund', 'ShipmentController@createRefund');

    // Tracking
    Route::post('/create-tracker', 'TrackerController@createTracker');
    Route::get('/tracker/{id}', 'TrackerController@retrieveTracker');
    Route::get('/trackers', 'TrackerController@retrieveTrackers');

    // Insurance
    Route::post('/create-insurance', 'InsuranceController@createInsurance');
    Route::get('/insurances', 'InsuranceController@retrieveInsurances');

    // Carriers
    Route::get('/carrier/{id}', 'CarrierController@retrieveCarrier');
    Route::get('/carriers', 'CarrierController@retrieveCarriers');
});
