<?php

namespace App\Http\Controllers;

use EasyPost\EasyPostClient;
use EasyPost\Exception\Api\ApiException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    /**
     * Retrieve a CarrierAccount.
     *
     * @param Request $request
     * @param string $id
     * @return View|RedirectResponse
     */
    public function retrieveCarrier(Request $request, string $id): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $carrier = $client->carrierAccount->retrieve($id);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('record')->with(['json' => $carrier]);
    }

    /**
     * Retrieve a list of CarrierAccount objects.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function retrieveCarriers(Request $request): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $carriers = $client->carrierAccount->all();
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('carriers')->with(['json' => $carriers]);
    }
}
