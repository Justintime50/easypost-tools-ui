<?php

namespace App\Http\Controllers;

use EasyPost\Exception\Api\ApiException;
use EasyPost\Exception\General\EasyPostException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Create an Address.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createAddress(Request $request): RedirectResponse
    {
        $request->validate([
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

        $client = $request->session()->get('client');

        try {
            $address = $client->address->create(
                [
                    'name'      => $request->input('name'),
                    'company'   => $request->input('company'),
                    'street1'   => $request->input('street1'),
                    'street2'   => $request->input('street2'),
                    'city'      => $request->input('city'),
                    'state'     => $request->input('state'),
                    'zip'       => $request->input('zip'),
                    'country'   => $request->input('country'),
                    'phone'     => $request->input('phone'),
                    'email'     => $request->input('email'),
                ]
            );
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'Address created!');
        return redirect('/')->with(['json' => $address]);
    }

    /**
     * Retrieve an Address.
     *
     * @param Request $request
     * @return View
     */
    public function retrieveAddress(Request $request, string $id): View
    {
        $client = $request->session()->get('client');

        try {
            $json = $client->address->retrieve($id);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('app', compact('json'));
    }

    /**
     * Retrieve a list of Address objects.
     *
     * @param Request $request
     * @return View
     */
    public function retrieveAddresses(Request $request): View
    {
        $client = $request->session()->get('client');

        try {
            $json = $client->address->all();
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('addresses', compact('json'));
    }
}
