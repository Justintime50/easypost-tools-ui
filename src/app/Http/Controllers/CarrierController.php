<?php

namespace App\Http\Controllers;

use EasyPost\Exception\General\EasyPostException;

class CarrierController extends Controller
{
    /**
     * Retrieve a CarrierAccount.
     *
     * @param string $id
     * @return mixed
     */
    public function retrieveCarrier(string $id)
    {
        $client = request()->get('client');

        try {
            $carriers = $client->carrierAccount->retrieve($id);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        $response = $carriers;

        session()->flash('message', 'CARRIER RETRIEVED');
        return view('app')->with(['json' => $response]);
    }

    /**
     * Retrieve a list of CarrierAccount objects.
     *
     * @return mixed
     */
    public function retrieveCarriers()
    {
        $client = request()->get('client');

        try {
            $response = $client->carrierAccount->all();
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'CARRIERS RETRIEVED');
        return view('carriers')->with(['json' => $response]);
    }
}
