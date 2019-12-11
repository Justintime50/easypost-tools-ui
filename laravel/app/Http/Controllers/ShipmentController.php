<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;

EasyPost::setApiKey(env('EASYPOST_API_KEY'));

class ShipmentController extends Controller
{
    /**
     * createShipment
     */
    public function createShipment(Request $request)
    {
        request()->validate([
            'to_street1'   => 'required|string',
            'to_street2'   => 'nullable|string',
            'to_city'      => 'required|string',
            'to_state'     => 'required|string',
            'to_zip'       => 'required|string',
            'to_country'   => 'nullable|string',
            'to_company'   => 'nullable|string',
            'to_phone'     => 'nullable',

            'from_street1'   => 'required|string',
            'from_street2'   => 'nullable|string',
            'from_city'      => 'required|string',
            'from_state'     => 'required|string',
            'from_zip'       => 'required|string',
            'from_country'   => 'nullable|string',
            'from_company'   => 'nullable|string',
            'from_phone'     => 'nullable',

            'length'    => 'required|string',
            'width'     => 'required|string',
            'height'    => 'required|string',
            'weight'    => 'required|string',
        ]);

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

        $response = $shipment;

        /*if ($shipment->to_address->verifications->delivery->success == false || $shipment->from_address->verifications->delivery->success == false) {
            session()->flash("error", "ERRORS: $shipment");
            return redirect('/');
        }*/

        /*foreach($shipment->rates as $rate) {
            echo $rate;
        }*/

        $shipment->buy($shipment->lowest_rate(array('USPS'), array('First')));
        $label = $shipment->postage_label->label_url;

        session()->flash("message", "SHIPMENT CREATED");
        return redirect()->back()->with(['response' => $response, 'label' => $label]);
    }

    /**
     * retrieveShipment
     */
    public function retrieveShipment(Request $request)
    {
        try {
            $shipment = \EasyPost\Shipment::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * retrieveShipments
     *
     * @param Request $request
     * @return void
     */
    public function retrieveShipments(Request $request)
    {
        try {
            $shipments = \EasyPost\Shipment::all(array(
                # "page_size" => 2,
                # 'purchased' => false,
                # "start_datetime" => "2016-01-02T08:50:00Z"
            ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipments;

        session()->flash("message", "SHIPMENTS RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * createRefund
     *
     * @param Request $request
     * @return void
     */
    public function createRefund(Request $request)
    {
        try {
            $shipment = \EasyPost\Shipment::create(request()->get('id'));
            $shipment->refund();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT REFUNDED");
        return redirect()->back()->with(['response' => $response]);
    }
}
