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
    return view('welcome');
});
Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/create-address', 'AddressController@createAddress');
Route::post('/retrieve-address', 'AddressController@retrieveAddress');

Route::post('/create-parcel', 'ParcelController@createParcel');
Route::post('/retrieve-parcel', 'ParcelController@retrieveParcel');

Route::post('/create-shipment', 'ShipmentController@createShipment');
Route::post('/retrieve-shipment', 'ShipmentController@retrieveShipment');
