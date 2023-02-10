<?php

namespace App\Http\Controllers;

use EasyPost\Address;

class AddressController extends Controller
{
    /**
     * Create an address.
     *
     * @return mixed
     */
    public function createAddress()
    {
        request()->validate([
            'name'     => 'nullable|string',
            'company'  => 'nullable|string',
            'street1'  => 'required|string',
            'street2'  => 'nullable|string',
            'city'     => 'nullable|string',
            'state'    => 'nullable|string',
            'zip'      => 'required|string',
            'country'  => 'nullable|string',
            'phone'    => 'nullable|string',
            'email'    => 'nullable|string',
        ]);

        try {
            $address = Address::create(
                [
                    'name'      => request()->get('name'),
                    'company'   => request()->get('company'),
                    'street1'   => request()->get('street1'),
                    'street2'   => request()->get('street2'),
                    'city'      => request()->get('city'),
                    'state'     => request()->get('state'),
                    'zip'       => request()->get('zip'),
                    'country'   => request()->get('country'),
                    'phone'     => request()->get('phone'),
                    'email'     => request()->get('email'),
                ]
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'ADDRESS CREATED');
        return redirect('/')->with(['json' => $address]);
    }

    /**
     * Retrieve an address.
     *
     * @return mixed
     */
    public function retrieveAddress(string $id)
    {
        try {
            $json = Address::retrieve($id);
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('app', compact('json'));
    }

    /**
     * Retrieve a list of Address objects.
     *
     * @return mixed
     */
    public function retrieveAddresses()
    {
        try {
            $json = Address::all();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('addresses', compact('json'));
    }
}
