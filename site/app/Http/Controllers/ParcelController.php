<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
EasyPost::setApiKey(env('EASYPOST_API_KEY')); # TODO: Make this an env variable or plug it into the form everytime.

class ParcelController extends Controller
{
    public function createParcel(Request $request) {
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

        session()->flash("message", "PARCEL CREATED: $parcel");
        return redirect('/');
    }


    public function retrieveParcel(Request $request) {
        try {
            $parcel = \EasyPost\Parcel::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash("message", "PARCEL RETRIEVED: $parcel");
        return redirect('/');
    }
}
