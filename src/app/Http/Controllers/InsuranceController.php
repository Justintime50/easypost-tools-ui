<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;

EasyPost::setApiKey(env('EASYPOST_API_KEY'));

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
        request()->validate([

        ]);

        try {
            $insurance = \EasyPost\Insurance::create(
                array(
                    # "to_address" => $to_address,
                    # "from_address" => $from_address,
                    # "tracking_code" => "9400110898825022579493",
                    # "carrier" => "USPS",
                    # "amount" => "100.00",
                    # "reference" => "insuranceRef1"
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
            $insurance = \EasyPost\Insurance::retrieve(request()->get('id'));
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
            $insurances = \EasyPost\Insurance::all(array(
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
