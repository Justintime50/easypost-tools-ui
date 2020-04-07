<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
use \EasyPost\Shipment;
use \EasyPost\Address;
use \EasyPost\Parcel;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class ShipmentController extends Controller
{
    /**
     * createShipment
     */
    public function createShipment(Request $request)
    {
        // Decrypt stored API Key
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);

        if (request()->get("to_address") == null) {
            request()->validate([
                "to_street1"    => "required|string",
                "to_street2"    => "nullable|string",
                "to_city"       => "required|string",
                "to_state"      => "required|string",
                "to_zip"        => "required|string",
                "to_country"    => "nullable|string",
                "to_company"    => "nullable|string",
                "to_phone"      => "nullable",
            ]);
        } else {
            request()->validate([
                "to_address"    => "required|string",
            ]);
        }

        if (request()->get("from_address") == null) {
            request()->validate([
                "from_street1"   => "required|string",
                "from_street2"   => "nullable|string",
                "from_city"      => "required|string",
                "from_state"     => "required|string",
                "from_zip"       => "required|string",
                "from_country"   => "nullable|string",
                "from_company"   => "nullable|string",
                "from_phone"     => "nullable",
            ]);
        } else {
            request()->validate([
                "from_address"  => "required|string",
            ]);
        }

        if (request()->get("parcel") != null && request()->get("predefined_package") != null) {
            return back()->withError("Either a Parcel ID or a predefined package may be specified, not both.")->withInput();
        }

        if (request()->get("parcel") == null && request()->get("predefined_package") == null) {
            request()->validate([
                "length"    => "required|string",
                "width"     => "required|string",
                "height"    => "required|string",
                "weight"    => "required|string",
            ]);
        } elseif (request()->get("predefined_package") == null) {
            request()->validate([
                "parcel"    => "required|string",
            ]);
        } elseif (request()->get("parcel") == null) {
            request()->validate([
                "predefined_package"    => "required|string",
                "weight"                => "required|string"
            ]);
        }

        try {
            if (request()->get("to_address") != null) {
                $to_address = Address::retrieve(request()->get("to_address"));
            } else {
                $to_address = array(
                    "verify"  => array("delivery"),
                    "street1" => request()->get("to_street1"),
                    "street2" => request()->get("to_street2"),
                    "city"    => request()->get("to_city"),
                    "state"   => request()->get("to_state"),
                    "zip"     => request()->get("to_zip"),
                    "country" => request()->get("to_country"),
                    "company" => request()->get("to_company"),
                    "phone"   => request()->get("to_phone"),
                );
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        try {
            if (request()->get("from_address") != null) {
                $from_address = Address::retrieve(request()->get("from_address"));
            } else {
                $from_address = array(
                    "verify"  => array("delivery"),
                    "street1" => request()->get("from_street1"),
                    "street2" => request()->get("from_street2"),
                    "city"    => request()->get("from_city"),
                    "state"   => request()->get("from_state"),
                    "zip"     => request()->get("from_zip"),
                    "country" => request()->get("from_country"),
                    "company" => request()->get("from_company"),
                    "phone"   => request()->get("from_phone"),
                );
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        try {
            if (request()->get("parcel") != null) {
                $parcel = Parcel::retrieve(request()->get("parcel"));
            } elseif (request()->get("predefined_package") != null) {
                $parcel = Parcel::create(array(
                    "predefined_package"    => request()->get("predefined_package"),
                    "weight"                => request()->get("weight"),
                ));
            } else {
                $parcel = array(
                    "length"    => request()->get("length"),
                    "width"     => request()->get("width"),
                    "height"    => request()->get("height"),
                    "weight"    => request()->get("weight"),
                );
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        try {
            $shipment = Shipment::create(
                array(
                    "to_address"    => $to_address,
                    "from_address"  => $from_address,
                    "parcel"        => $parcel
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;
        $json = json_decode($response); 

        $rates = $shipment->rates;

        usort(
            $rates,
            function ($a, $b) {
                return $a->rate < $b->rate ? -1 : 1;
            }
        );

        session()->flash("message", "SHIPMENT CREATED");
        return view("rates")->with(["json" => $json, "rates" => $rates]);
    }

    /**
     * retrieveShipment
     */
    public function retrieveShipment(Request $request)
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
            $shipment = Shipment::retrieve(request()->get("id"));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT RETRIEVED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * retrieveShipments
     *
     * @param Request $request
     * @return void
     */
    public function retrieveShipments(Request $request)
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
            $shipments = Shipment::all(array(
                "purchased" => false
            ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipments;
        $json = json_decode($response); 

        session()->flash("message", "SHIPMENTS RETRIEVED");
        return view("shipments")->with(["json" => $json]);
    }

    /**
     * createRefund
     *
     * @param Request $request
     * @return void
     */
    public function createRefund(Request $request)
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
            $shipment = Shipment::retrieve(request()->get("id"));
            $shipment->refund();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT REFUNDED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * buyShipment
     */
    public function buyShipment(Request $request)
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
            $shipment = Shipment::retrieve(request()->get("shipment_id"));
            $shipment->buy(array(
                "id" => request()->get("rate_id"),
            ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "LABEL PURCHASED");
        return view("app")->with(["json" => $response]);
    }
}
