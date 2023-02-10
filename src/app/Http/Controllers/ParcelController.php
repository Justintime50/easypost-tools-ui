<?php

namespace App\Http\Controllers;

use EasyPost\Exception\General\EasyPostException;

class ParcelController extends Controller
{
    /**
     * Create a Parcel.
     */
    public function createParcel()
    {
        if (request()->get('predefined_package') == null) {
            request()->validate([
                'length'    => 'nullable|string',
                'width'     => 'nullable|string',
                'height'    => 'nullable|string',
                'weight'    => 'required|string',
            ]);
        } else {
            request()->validate([
                'predefined_package'    => 'required|string',
                'weight'                => 'required|string'
            ]);
        }

        $client = request()->get('client');

        try {
            if (request()->get('predefined_package') != null) {
                $parcel = $client->parcel->create([
                    'predefined_package'    => request()->get('predefined_package'),
                    'weight'                => request()->get('weight'),
                ]);
            } else {
                $parcel = $client->parcel->create(
                    [
                        'length'    => request()->get('length'),
                        'width'     => request()->get('width'),
                        'height'    => request()->get('height'),
                        'weight'    => request()->get('weight'),
                    ]
                );
            }
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'PARCEL CREATED');
        return view('app')->with(['json' => $parcel]);
    }
}
