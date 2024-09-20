<?php

namespace App\Http\Controllers;

use EasyPost\EasyPostClient;
use EasyPost\Exception\Api\ApiException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    /**
     * Create an Insurance.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createInsurance(Request $request): RedirectResponse
    {
        if ($request->input('to_address') == null) {
            $request->validate([
                'to_name'       => 'nullable|string',
                'to_company'    => 'nullable|string',
                'to_street1'    => 'nullable|string',
                'to_street2'    => 'nullable|string',
                'to_city'       => 'nullable|string',
                'to_state'      => 'nullable|string',
                'to_zip'        => 'nullable|string',
                'to_country'    => 'nullable|string',
                'to_phone'      => 'nullable|string',
                'to_email'      => 'nullable|string',
            ]);
        }

        if ($request->input('from_address') == null) {
            $request->validate([
                'from_name'       => 'nullable|string',
                'from_company'    => 'nullable|string',
                'from_street1'    => 'nullable|string',
                'from_street2'    => 'nullable|string',
                'from_city'       => 'nullable|string',
                'from_state'      => 'nullable|string',
                'from_zip'        => 'nullable|string',
                'from_country'    => 'nullable|string',
                'from_phone'      => 'nullable|string',
                'from_email'      => 'nullable|string',
            ]);
        }

        $request->validate([
            'to_address'        => 'nullable|string',
            'from_address'      => 'nullable|string',
            'tracking_code'     => 'required|string',
            'carrier'           => 'required|string',
            'amount'            => 'required|string',
        ]);

        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            if ($request->input('to_address') != null) {
                $toAddress = $client->address->retrieve($request->input('to_address'));
            } else {
                $toAddress = [
                    'name'      => $request->input('to_name'),
                    'company'   => $request->input('to_company'),
                    'street1'   => $request->input('to_street1'),
                    'street2'   => $request->input('to_street2'),
                    'city'      => $request->input('to_city'),
                    'state'     => $request->input('to_state'),
                    'zip'       => $request->input('to_zip'),
                    'country'   => $request->input('to_country'),
                    'phone'     => $request->input('to_phone'),
                    'email'     => $request->input('to_email'),
                ];
            }

            if ($request->input('from_address') != null) {
                $fromAddress = $client->address->retrieve($request->input('from_address'));
            } else {
                $fromAddress = [
                    'name'      => $request->input('from_name'),
                    'company'   => $request->input('from_company'),
                    'street1'   => $request->input('from_street1'),
                    'street2'   => $request->input('from_street2'),
                    'city'      => $request->input('from_city'),
                    'state'     => $request->input('from_state'),
                    'zip'       => $request->input('from_zip'),
                    'country'   => $request->input('from_country'),
                    'phone'     => $request->input('from_phone'),
                    'email'     => $request->input('from_email'),
                ];
            }

            $insurance = $client->insurance->create(
                [
                    'to_address' => $toAddress,
                    'from_address' => $fromAddress,
                    'tracking_code' => $request->input('tracking_code'),
                    'carrier' => $request->input('carrier'),
                    'amount' => $request->input('amount'),
                ]
            );
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return redirect("/insurances/$insurance->id");
    }

    /**
     * Retrieve an Insurance.
     *
     * @param Request $request
     * @param string $id
     * @return View|RedirectResponse
     */
    public function retrieveInsurance(Request $request, string $id)
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $insurance = $client->insurance->retrieve($id);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('record')->with(['json' => $insurance]);
    }

    /**
     * Retrieve a list of Insurance objects.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function retrieveInsurances(Request $request)
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $insurances = $client->insurance->all();
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('insurances')->with(['json' => $insurances]);
    }
}
