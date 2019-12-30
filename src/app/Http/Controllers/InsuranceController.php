<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
use \EasyPost\Insurance;
use \EasyPost\Address;

EasyPost::setApiKey(Auth::user()->api_key);

class InsuranceController extends Controller
{
    /**
     * createInsurance
     *
     * @param Request $request
     * @return void
     */
    public function createInsurance(Request $request)
    {
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

        request()->validate([
            'to_address'        => 'required|string',
            'from_address'      => 'required|string',
            'tracking_code'     => 'required|string',
            # 'carrier'           => 'required|string',
            'amount'            => 'required|string',
        ]);

        try {
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

            $insurance = Insurance::create(
                array(
                    "to_address" => $to_address,
                    "from_address" => $from_address,
                    "tracking_code" => request()->get('tracking_code'),
                    # "carrier" => request()->get('carrier'),
                    "amount" => request()->get('amount'),
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $insurance;

        session()->flash("message", "INSURANCE CREATED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * retrieveInsurance
     *
     * @param Request $request
     * @return void
     */
    public function retrieveInsurance(Request $request)
    {
        try {
            $insurance = Insurance::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $insurance;

        session()->flash("message", "INSURANCE RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * retrieveInsurances
     *
     * @param Request $request
     * @return void
     */
    public function retrieveInsurances(Request $request)
    {
        try {
            $insurances = Insurance::all(array(
                # "page_size" => 2,
                # "start_datetime" => "2016-01-02T08:50:00Z"
              ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $insurances;

        session()->flash("message", "INSURANCES RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }
}
