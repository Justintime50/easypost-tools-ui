<?php

namespace App\Http\Controllers;

use EasyPost\Exception\General\EasyPostException;

class InsuranceController extends Controller
{
    /**
     * Create an Insurance.
     *
     * @return mixed
     */
    public function createInsurance()
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

        $client = request()->get('client');

        try {
            if (request()->get('to_address') != null) {
                $toAddress = $client->address->retrieve(request()->get('to_address'));
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
                $fromAddress = $client->address->retrieve(request()->get('from_address'));
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

            $insurance = $client->insurance->create(
                [
                    'to_address' => $toAddress,
                    'from_address' => $fromAddress,
                    'tracking_code' => request()->get('tracking_code'),
                    'carrier' => request()->get('carrier'),
                    'amount' => request()->get('amount'),
                ]
            );
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        $response = $insurance;

        session()->flash('message', 'INSURANCE CREATED');
        return redirect('/')->with(['response' => $response]);
    }

    /**
     * Retrieve an Insurance.
     *
     * @param string $id
     * @return mixed
     */
    public function retrieveInsurance(string $id)
    {
        $client = request()->get('client');

        try {
            $response = $client->insurance->retrieve($id);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'INSURANCE RETRIEVED');
        return view('app')->with(['json' => $response]);
    }

    /**
     * Retrieve a list of Insurance objects.
     *
     * @return mixed
     */
    public function retrieveInsurances()
    {
        $client = request()->get('client');

        try {
            $json = $client->insurance->all();
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'INSURANCES RETRIEVED');
        return view('insurance')->with(['json' => $json]);
    }
}
