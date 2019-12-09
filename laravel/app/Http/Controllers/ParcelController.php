<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
EasyPost::setApiKey(env('EASYPOST_API_KEY'));

class ParcelController extends Controller
{
    /**
     * createParcel
     */
    public function createParcel(Request $request) {
        request()->validate([
            'length'    => 'required|string',
            'width'     => 'required|string',
            'height'    => 'required|string',
            'weight'    => 'required|string',
        ]);

        try {
            $parcel = \EasyPost\Parcel::create(
                array(
                    "length"    => request()->get('length'),
                    "width"     => request()->get('width'),
                    "height"    => request()->get('height'),
                    "weight"    => request()->get('weight'),
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $parcel;

        session()->flash("message", "PARCEL CREATED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * retrieveParcel
     */
    public function retrieveParcel(Request $request) {
        try {
            $parcel = \EasyPost\Parcel::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $parcel;

        session()->flash("message", "PARCEL RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * retrieveParcels
     *
     * @param Request $request
     * @return void
     */
    public function retrieveParcels (Request $request) {
        try {
            $parcels = \EasyPost\Parcel::all(array(
                # "page_size" => 2,
                "start_datetime" => "2016-01-02T08:50:00Z"
              ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $parcels;

        session()->flash("message", "ADDRESSES RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }
}
