<?php

namespace App\Http\Controllers;

use EasyPost\CarrierAccount;
use EasyPost\EasyPost;
use Illuminate\Http\Request;

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
        try {
            $carriers = CarrierAccount::retrieve($id);
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
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
        try {
            $response = CarrierAccount::all();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'CARRIERS RETRIEVED');
        return view('carriers')->with(['json' => $response]);
    }
}
