<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
use \EasyPost\Parcel;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class ParcelController extends Controller
{
    /**
     * createParcel
     */
    public function createParcel(Request $request)
    {
        // Decrypt stored API Key
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);

        if (request()->get("predefined_package") == null) {
            request()->validate([
                "length"    => "required|string",
                "width"     => "required|string",
                "height"    => "required|string",
                "weight"    => "required|string",
            ]);
        } else {
            request()->validate([
                "predefined_package"    => "required|string",
                "weight"                => "required|string"
            ]);
        }

        try {
            if (request()->get("predefined_package") != null) {
                $parcel = Parcel::create(array(
                    "predefined_package"    => request()->get("predefined_package"),
                    "weight"                => request()->get("weight"),
                ));
            } else {
            $parcel = Parcel::create(
                array(
                    "length"    => request()->get("length"),
                    "width"     => request()->get("width"),
                    "height"    => request()->get("height"),
                    "weight"    => request()->get("weight"),
                    )
                );
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $parcel;

        session()->flash("message", "PARCEL CREATED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * retrieveParcel
     */
    public function retrieveParcel(Request $request)
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
            $parcel = Parcel::retrieve(request()->get("id"));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $parcel;

        session()->flash("message", "PARCEL RETRIEVED");
        return view("app")->with(["json" => $response]);
    }
}
