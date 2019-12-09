<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
EasyPost::setApiKey(env('EASYPOST_API_KEY'));

class AddressController extends Controller
{
    /**
     * createAddress
     *
     * @param Request $request
     * @return void
     */
    public function createAddress (Request $request) {
        request()->validate([
            'street1'   => 'required|string',
            'street2'   => 'nullable|string',
            'city'      => 'required|string',
            'state'     => 'required|string',
            'zip'       => 'required|string',
            'country'   => 'nullable|string',
            'company'   => 'nullable|string',
            'phone'     => 'nullable',
        ]);

        try {
            $address = \EasyPost\Address::create(
                array(
                    "verify"  => array("delivery"),
                    "street1" => request()->get('street1'),
                    "street2" => request()->get('street2'),
                    "city"    => request()->get('city'),
                    "state"   => request()->get('state'),
                    "zip"     => request()->get('zip'),
                    "country" => request()->get('country'),
                    "company" => request()->get('company'),
                    "phone"   => request()->get('phone'),
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        if ($address->verifications->delivery->success == false) {
            session()->flash("error", "ADDRESS ENTERED IS NOT A VERIFIED ADDRESS BUT THE RECORD WAS CREATED ANYWAY");
            return view('/welcome', compact('response'));
        }

        $response = $address;

        session()->flash("message", "ADDRESS CREATED");
        return view('/welcome', compact('response'));
    }

    /**
     * retrieveAddress
     *
     * @param Request $request
     * @return void
     */
    public function retrieveAddress (Request $request) {
        try {
            $address = \EasyPost\Address::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $address;

        session()->flash("message", "ADDRESS RETRIEVED: $response");
        return view('/welcome', compact('response'));
    }
}
