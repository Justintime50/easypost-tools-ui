<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
EasyPost::setApiKey(''); # TODO: Make this an env variable or plug it into the form everytime.

class AddressController extends Controller
{
    public function createFromAddress (Request $request) {

    }


    public function createToAddress (Request $request) {
        $to_address = \EasyPost\Address::create(
            array(
                "name"    => "Dr. Steve Brule",
                "street1" => "179 N Harbor Dr",
                "city"    => "Redondo Beach",
                "state"   => "CA",
                "zip"     => "90277",
                "phone"   => "310-808-5243"
            )
        );


        session()->flash("message", "To Address created: $to_address->id");
        return redirect('/');
    }


    public function readFromAddress (Request $request) {

    }


    public function readToAddress (Request $request) {

    }
}
