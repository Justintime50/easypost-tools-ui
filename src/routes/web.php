<?php

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

Route::get('/', function () {
    return view('app');
});
Route::get('/app', function () {
    return view('app');
});

Auth::routes();

Route::get('/account', 'HomeController@index')->name('account');

Route::post('/create-address', 'AddressController@createAddress');
Route::post('/retrieve-address', 'AddressController@retrieveAddress');
Route::post('/retrieve-addresses', 'AddressController@retrieveAddresses');

Route::post('/create-parcel', 'ParcelController@createParcel');
Route::post('/retrieve-parcel', 'ParcelController@retrieveParcel');
Route::post('/retrieve-parcels', 'ParcelController@retrieveParcels');

Route::post('/create-shipment', 'ShipmentController@createShipment');
Route::post('/retrieve-shipment', 'ShipmentController@retrieveShipment');
Route::post('/retrieve-shipments', 'ShipmentController@retrieveShipments');
Route::post('/buy-label', 'ShipmentController@buyLabel');

Route::post('/create-tracking', 'TrackerController@createTracker');
Route::post('/retrieve-tracker', 'TrackerController@retrieveTracker');
Route::post('/retrieve-trackers', 'TrackerController@retrieveTrackers');

Route::post('/create-insurance', 'InsuranceController@createInsurance');
Route::post('/retrieve-insurance', 'InsuranceController@retrieveInsurance');
Route::post('/retrieve-insurances', 'InsuranceController@retrieveInsurances');

Route::post('/create-refund', 'ShipmentController@createRefund');

Route::post('/retrieve-carriers', 'CarrierController@retrieveCarriers');
