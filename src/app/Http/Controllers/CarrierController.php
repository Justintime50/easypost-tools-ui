<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
use \EasyPost\CarrierAccount;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class CarrierController extends Controller
{
    /**
     * Retrieve a carrier account
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveCarrier(Request $request)
    {
        // Decrypt stored API Key
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);

        try {
            $carriers = CarrierAccount::retrieve(request()->get("id"));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $carriers;

        session()->flash("message", "CARRIER RETRIEVED");
        return view('app')->with(['json' => $response]);
    }

    /**
     * Retrieve a list of carrier accounts
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveCarriers(Request $request)
    {
        // Decrypt stored API Key
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);

        try {
            $carriers = CarrierAccount::all();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $carriers;

        session()->flash("message", "CARRIERS RETRIEVED");
        return view('carriers')->with(['json' => $response]);
    }
}
