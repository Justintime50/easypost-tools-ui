<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class CarrierController extends Controller
{
    /**
     * retrieveCarriers
     *
     * @param Request $request
     * @return void
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
            $carrier_types = \EasyPost\CarrierAccount::types();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $carrier_types;

        session()->flash("message", "CARRIERS RETRIEVED");
        return redirect('/')->with(['response' => $response]);
    }
}
