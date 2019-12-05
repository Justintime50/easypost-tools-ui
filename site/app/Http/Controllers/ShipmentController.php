<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
EasyPost::setApiKey(env('EASYPOST_API_KEY')); # TODO: Make this an env variable or plug it into the form everytime.

class ShipmentController extends Controller
{
    public function createShipment(Request $request) {
        try {
            $shipment = \EasyPost\Shipment::create(
                array(
                    "to_address" => array(
                        "verify"  => array("delivery"),
                        "street1" => request()->get('to_street1'),
                        "street2" => request()->get('to_street2'),
                        "city"    => request()->get('to_city'),
                        "state"   => request()->get('to_state'),
                        "zip"     => request()->get('to_zip'),
                        "country" => request()->get('to_country'),
                        "company" => request()->get('to_company'),
                        "phone"   => request()->get('to_phone'),
                    ),

                    "from_address" => array(
                        "verify"  => array("delivery"),
                        "street1" => request()->get('from_street1'),
                        "street2" => request()->get('from_street2'),
                        "city"    => request()->get('from_city'),
                        "state"   => request()->get('from_state'),
                        "zip"     => request()->get('from_zip'),
                        "country" => request()->get('from_country'),
                        "company" => request()->get('from_company'),
                        "phone"   => request()->get('from_phone'),
                    ),

                    "parcel" => array(
                        "length"    => request()->get('length'),
                        "width"     => request()->get('width'),
                        "height"    => request()->get('height'),
                        "weight"    => request()->get('weight'),
                    ),
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        /*if ($shipment->to_address->verifications->delivery->success == false || $shipment->from_address->verifications->delivery->success == false) {
            session()->flash("error", "ERRORS: $shipment");
            return redirect('/');
        }*/

        /*foreach($shipment->rates as $rate) {
            echo $rate;
        }*/

        $shipment->buy($shipment->lowest_rate(array('USPS'), array('First')));
        $label = $shipment->postage_label->label_url;
        session()->flash("message", "SHIPMENT CREATED: $label");
        return redirect('/');
    }


    public function retrieveShipment(Request $request) {
        try {
            $shipments = \EasyPost\Shipment::all(array(
                "start_datetime" => "2016-01-02T08:50:00Z",
            ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash("message", "SHIPMENTS RETRIEVED: $shipments");
        return redirect('/');
    }
}
