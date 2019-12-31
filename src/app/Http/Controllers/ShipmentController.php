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

        if (request()->get('to_address') == null) {
            request()->validate([
                'to_street1'    => 'required|string',
                'to_street2'    => 'nullable|string',
                'to_city'       => 'required|string',
                'to_state'      => 'required|string',
                'to_zip'        => 'required|string',
                'to_country'    => 'nullable|string',
                'to_company'    => 'nullable|string',
                'to_phone'      => 'nullable',
            ]);
        } else {
            request()->validate([
                'to_address'    => 'required|string',
            ]);
        }

        if (request()->get('from_address') == null) {
            request()->validate([
                'from_street1'   => 'required|string',
                'from_street2'   => 'nullable|string',
                'from_city'      => 'required|string',
                'from_state'     => 'required|string',
                'from_zip'       => 'required|string',
                'from_country'   => 'nullable|string',
                'from_company'   => 'nullable|string',
                'from_phone'     => 'nullable',
            ]);
        } else {
            request()->validate([
                'from_address'  => 'required|string',
            ]);
        }

        if (request()->get('parcel') == null) {
            request()->validate([
                'length'    => 'required|string',
                'width'     => 'required|string',
                'height'    => 'required|string',
                'weight'    => 'required|string',
            ]);
        } else {
            request()->validate([
                'parcel'    => 'required|string',
            ]);
        }

        if (request()->get('to_address') != null) {
            $to_address = Address::retrieve(request()->get('to_address'));
        } else {
            $to_address = array(
                "verify"  => array("delivery"),
                "street1" => request()->get('to_street1'),
                "street2" => request()->get('to_street2'),
                "city"    => request()->get('to_city'),
                "state"   => request()->get('to_state'),
                "zip"     => request()->get('to_zip'),
                "country" => request()->get('to_country'),
                "company" => request()->get('to_company'),
                "phone"   => request()->get('to_phone'),
            );
        }

        if (request()->get('from_address') != null) {
            $from_address = Address::retrieve(request()->get('from_address'));
        } else {
            $from_address = array(
                "verify"  => array("delivery"),
                "street1" => request()->get('from_street1'),
                "street2" => request()->get('from_street2'),
                "city"    => request()->get('from_city'),
                "state"   => request()->get('from_state'),
                "zip"     => request()->get('from_zip'),
                "country" => request()->get('from_country'),
                "company" => request()->get('from_company'),
                "phone"   => request()->get('from_phone'),
            );
        }

        if (request()->get('parcel') != null) {
            $parcel = Parcel::retrieve(request()->get('parcel'));
        } else {
            $parcel = array(
                "length"    => request()->get('length'),
                "width"     => request()->get('width'),
                "height"    => request()->get('height'),
                "weight"    => request()->get('weight'),
            );
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

        # TODO: Add in error handling for rates that cannot be returned (eg: due to bad addresses)

        $response = $shipment;

        $rates = $shipment->rates;

        session()->flash("message", "SHIPMENT CREATED");
        return redirect('/')->with(['response' => $response, 'rates' => $rates]);
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
            $shipment = Shipment::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT RETRIEVED");
        return redirect('/')->with(['response' => $response]);
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
                # "page_size" => 2,
                # 'purchased' => false,
                # "start_datetime" => "2016-01-02T08:50:00Z"
            ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipments;

        session()->flash("message", "SHIPMENTS RETRIEVED");
        return redirect('/')->with(['response' => $response]);
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
            $shipment = Shipment::create(request()->get('id'));
            $shipment->refund();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT REFUNDED");
        return redirect('/')->with(['response' => $response]);
    }

    /**
     * buyLabel
     */
    public function buyLabel(Request $request)
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
            $shipment = Shipment::retrieve(request()->get('shipment_id'));
            $shipment->buy(array(
                "id" => request()->get('rate_id'),
                # 'rate' => $shipment->lowest_rate(),
                # 'insurance' => 100
            ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        $label = $shipment->postage_label->label_url;

        session()->flash("message", "LABEL PURCHASED");
        return redirect('/')->with(['response' => $response, 'label' => $label]);
    }
}
