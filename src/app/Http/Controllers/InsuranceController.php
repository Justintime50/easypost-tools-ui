<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyPost\EasyPost;
use EasyPost\Insurance;
use EasyPost\Address;

class InsuranceController extends Controller
{
    /**
     * Create an insurance
     *
     * @param Request $request
     * @return mixed
     */
    public function createInsurance(Request $request)
    {
        if (request()->get('to_address') == null) {
            request()->validate([
                'to_street1'    => 'required|string',
                'to_street2'    => 'nullable|string',
                'to_city'       => 'nullable|string',
                'to_state'      => 'nullable|string',
                'to_zip'        => 'required|string',
                'to_country'    => 'nullable|string',
                'to_company'    => 'nullable|string',
                'to_phone'      => 'nullable|string',
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
                'from_city'      => 'nullable|string',
                'from_state'     => 'nullable|string',
                'from_zip'       => 'required|string',
                'from_country'   => 'nullable|string',
                'from_company'   => 'nullable|string',
                'from_phone'     => 'nullable|string',
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
            'carrier'           => 'nullable|string',
            'amount'            => 'required|string|max:5000',
        ]);

        try {
            if (request()->get('to_address') != null) {
                $toAddress = Address::retrieve(request()->get('to_address'));
            } else {
                $toAddress = [
                    'verify'  => ['delivery'],
                    'street1' => request()->get('to_street1'),
                    'street2' => request()->get('to_street2'),
                    'city'    => request()->get('to_city'),
                    'state'   => request()->get('to_state'),
                    'zip'     => request()->get('to_zip'),
                    'country' => request()->get('to_country'),
                    'company' => request()->get('to_company'),
                    'phone'   => request()->get('to_phone'),
                ];
            }

            if (request()->get('from_address') != null) {
                $fromAddress = Address::retrieve(request()->get('from_address'));
            } else {
                $fromAddress = [
                    'verify'  => ['delivery'],
                    'street1' => request()->get('from_street1'),
                    'street2' => request()->get('from_street2'),
                    'city'    => request()->get('from_city'),
                    'state'   => request()->get('from_state'),
                    'zip'     => request()->get('from_zip'),
                    'country' => request()->get('from_country'),
                    'company' => request()->get('from_company'),
                    'phone'   => request()->get('from_phone'),
                ];
            }

            $insurance = Insurance::create(
                [
                    'to_address' => $toAddress,
                    'from_address' => $fromAddress,
                    'tracking_code' => request()->get('tracking_code'),
                    'carrier' => request()->get('carrier'),
                    'amount' => request()->get('amount'),
                ]
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $insurance;

        session()->flash('message', 'INSURANCE CREATED');
        return view('app')->with(['response' => $response]);
    }

    /**
     * Retrieve an insurance
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveInsurance(Request $request)
    {
        try {
            $insurance = Insurance::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $insurance;

        session()->flash('message', 'INSURANCE RETRIEVED');
        return view('app')->with(['json' => $response]);
    }

    /**
     * Retrieve a list of insurances
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveInsurances(Request $request)
    {
        try {
            $insurances = Insurance::all();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $insurances;
        $json = json_decode($response);

        session()->flash('message', 'INSURANCES RETRIEVED');
        return view('insurance')->with(['json' => $json]);
    }
}
