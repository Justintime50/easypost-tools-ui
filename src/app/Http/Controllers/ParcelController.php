<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyPost\EasyPost;
use EasyPost\Parcel;

class ParcelController extends Controller
{
    /**
     * Create a parcel
     */
    public function createParcel(Request $request)
    {
        if (request()->get("predefined_package") == null) {
            request()->validate([
                "length"    => "nullable|string",
                "width"     => "nullable|string",
                "height"    => "nullable|string",
                "weight"    => "required|string",
            ]);
        } else {
            request()->validate([
                "predefined_package"    => "required|string",
                "weight"                => "required|string"
            ]);
        }

        try {
            if (request()->get("predefined_package") != null) {
                $parcel = Parcel::create(array(
                    "predefined_package"    => request()->get("predefined_package"),
                    "weight"                => request()->get("weight"),
                ));
            } else {
                $parcel = Parcel::create(
                    array(
                        "length"    => request()->get("length"),
                        "width"     => request()->get("width"),
                        "height"    => request()->get("height"),
                        "weight"    => request()->get("weight"),
                    )
                );
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $parcel;

        session()->flash("message", "PARCEL CREATED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * Retrieve a parcel
     */
    public function retrieveParcel(Request $request)
    {
        try {
            $parcel = Parcel::retrieve(request()->get("id"));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $parcel;

        session()->flash("message", "PARCEL RETRIEVED");
        return view("app")->with(["json" => $response]);
    }
}
