<?php

namespace App\Http\Controllers;

use EasyPost\EasyPostClient;
use EasyPost\Exception\Api\ApiException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    /**
     * Create a Parcel.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createParcel(Request $request): RedirectResponse
    {
        if ($request->input('predefined_package') == null) {
            $request->validate([
                'length'    => 'nullable|numeric',
                'width'     => 'nullable|numeric',
                'height'    => 'nullable|numeric',
                'weight'    => 'required|numeric',
            ]);
        } else {
            $request->validate([
                'predefined_package'    => 'required|string',
                'weight'                => 'required|numeric'
            ]);
        }

        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            if ($request->input('predefined_package') != null) {
                $parcel = $client->parcel->create([
                    'predefined_package'    => $request->input('predefined_package'),
                    'weight'                => $request->input('weight'),
                ]);
            } else {
                $parcel = $client->parcel->create(
                    [
                        'length'    => $request->input('length'),
                        'width'     => $request->input('width'),
                        'height'    => $request->input('height'),
                        'weight'    => $request->input('weight'),
                    ]
                );
            }
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return redirect("/parcels/$parcel->id");
    }

    /**
     * Retrieve an Parcel.
     *
     * @param Request $request
     * @param string $id
     * @return View|RedirectResponse
     */
    public function retrieveParcel(Request $request, string $id): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $parcel = $client->parcel->retrieve($id);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('record')->with(['json' => $parcel]);
    }

    /**
     * Retrieve a list of Parcels.
     *
     * You can't actually retrieve a list of Parcels, there is no EasyPost endpoint for this,
     * so we just return the parcels page.
     *
     * @param Request $request
     * @return View
     */
    public function retrieveParcels(Request $request): View
    {
        return view('parcels');
    }
}
