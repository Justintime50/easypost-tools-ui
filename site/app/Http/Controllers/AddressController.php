<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
EasyPost::setApiKey(env('EASYPOST_API_KEY')); # TODO: Make this an env variable or plug it into the form everytime.


class AddressController extends Controller
{
    public function createAddress (Request $request) {

        $to_address = \EasyPost\Address::create(
            array(
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

        session()->flash("message", "TO ADDRESS CREATED: $to_address");
        return redirect('/');
    }


    public function retrieveAddress (Request $request) {
        $retrieved_address = \EasyPost\Address::retrieve(request()->get('id'));

        session()->flash("message", "ADDRESS RETRIEVED: $retrieved_address");
        return redirect('/');
    }
}
