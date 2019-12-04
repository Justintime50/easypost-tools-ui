<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
EasyPost::setApiKey(env('EASYPOST_API_KEY')); # TODO: Make this an env variable or plug it into the form everytime.

class AddressController extends Controller
{
    /**
     * createAddress
     *
     * @param Request $request
     * @return void
     */
    public function createAddress (Request $request) {
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
            session()->flash("error", "ADDRESS ENTERED IS NOT A VERIFIED ADDRESS BUT THE RECORD WAS CREATED ANYWAY: $address");
            return redirect('/');
        }

        session()->flash("message", "ADDRESS CREATED: $address");
        return redirect('/');
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

        session()->flash("message", "ADDRESS RETRIEVED: $address");
        return redirect('/');
    }
}
