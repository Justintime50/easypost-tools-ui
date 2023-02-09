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
    Route::get('/', function () {
        return view('app');
    });
    Route::get('/app', function () {
        return view('app');
    });

    Route::get('/account', 'HomeController@index')->name('account');

    Route::post('/update-api-key', 'UserController@updateApiKey');
});

// Decrypt and use the API key from the user's account on POST routes
Route::middleware(['auth', 'ApiKey'])->group(function () {
    // Addresses
    Route::post('/create-address', 'AddressController@createAddress');
    Route::get('/address/{id}', 'AddressController@retrieveAddress');
    Route::get('/addresses', 'AddressController@retrieveAddresses');

    // Parcels
    Route::post('/create-parcel', 'ParcelController@createParcel');
    Route::post('/retrieve-parcel', 'ParcelController@retrieveParcel');
    Route::post('/retrieve-parcels', 'ParcelController@retrieveParcels');

    // Shipments
    Route::post('/create-shipment', 'ShipmentController@createShipment');
    Route::post('/retrieve-shipment', 'ShipmentController@retrieveShipment');
    Route::post('/retrieve-shipments', 'ShipmentController@retrieveShipments');
    Route::post('/buy-shipment', 'ShipmentController@buyShipment');
    Route::post('/buy-stamp', 'ShipmentController@buyStamp');

    // Tracking
    Route::post('/create-tracking', 'TrackerController@createTracker');
    Route::post('/retrieve-tracker', 'TrackerController@retrieveTracker');
    Route::post('/retrieve-trackers', 'TrackerController@retrieveTrackers');

    // Insurance
    Route::post('/create-insurance', 'InsuranceController@createInsurance');
    Route::post('/retrieve-insurance', 'InsuranceController@retrieveInsurance');
    Route::post('/retrieve-insurances', 'InsuranceController@retrieveInsurances');

    // Refunds
    Route::post('/create-refund', 'ShipmentController@createRefund');

    // Carriers
    Route::post('/retrieve-carrier', 'CarrierController@retrieveCarrier');
    Route::post('/retrieve-carriers', 'CarrierController@retrieveCarriers');
});
