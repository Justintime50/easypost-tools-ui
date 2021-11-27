<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyPost\EasyPost;
use EasyPost\Address;

class AddressController extends Controller
{
    /**
     * Create an address
     *
     * @param Request $request
     * @return mixed
     */
    public function createAddress(Request $request)
    {
        request()->validate([
            "street1"   => "required|string",
            "street2"   => "nullable|string",
            "city"      => "nullable|string",
            "state"     => "nullable|string",
            "zip"       => "required|string",
            "country"   => "nullable|string",
            "company"   => "nullable|string",
            "phone"     => "nullable|string",
        ]);

        try {
            $address = Address::create(
                array(
                    "street1" => request()->get("street1"),
                    "street2" => request()->get("street2"),
                    "city"    => request()->get("city"),
                    "state"   => request()->get("state"),
                    "zip"     => request()->get("zip"),
                    "country" => request()->get("country"),
                    "company" => request()->get("company"),
                    "phone"   => request()->get("phone"),
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $address;

        session()->flash("message", "ADDRESS CREATED");
        return redirect("/")->with(["response" => $response]);
    }

    /**
     * Retrieve an address
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveAddress(Request $request)
    {
        try {
            $address = Address::retrieve(request()->get("id"));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $address;

        session()->flash("message", "ADDRESS RETRIEVED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * Retrieve a list of addresses
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveAddresses(Request $request)
    {
        try {
            $addresses = Address::all();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $addresses;
        $json = json_decode($response);

        session()->flash("message", "ADDRESSES RETRIEVED");
        return view("addresses")->with(["json" => $json]);
    }
}
