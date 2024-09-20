<?php

namespace App\Http\Controllers;

use EasyPost\EasyPostClient;
use EasyPost\Exception\Api\ApiException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Create a Shipment.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function createShipment(Request $request): View|RedirectResponse
    {
        if ($request->input('to_address') == null) {
            $request->validate([
                'to_name'       => 'nullable|string',
                'to_company'    => 'nullable|string',
                'to_street1'    => 'required|string',
                'to_street2'    => 'nullable|string',
                'to_city'       => 'nullable|string',
                'to_state'      => 'nullable|string',
                'to_zip'        => 'required|string',
                'to_country'    => 'nullable|string',
                'to_phone'      => 'nullable|string',
                'to_email'      => 'nullable|string',
            ]);
        } else {
            $request->validate([
                'to_address'    => 'required|string',
            ]);
        }

        if ($request->input('from_address') == null) {
            $request->validate([
                'from_name'       => 'nullable|string',
                'from_company'    => 'nullable|string',
                'from_street1'    => 'required|string',
                'from_street2'    => 'nullable|string',
                'from_city'       => 'nullable|string',
                'from_state'      => 'nullable|string',
                'from_zip'        => 'required|string',
                'from_country'    => 'nullable|string',
                'from_phone'      => 'nullable|string',
                'from_email'      => 'nullable|string',
            ]);
        } else {
            $request->validate([
                'from_address'  => 'required|string',
            ]);
        }

        if ($request->input('parcel') != null && $request->input('predefined_package') != null) {
            return back()->withError('Either a Parcel ID or a predefined package may be specified, not both.');
        }

        if ($request->input('parcel') == null && $request->input('predefined_package') == null) {
            $request->validate([
                'length'    => 'nullable|string',
                'width'     => 'nullable|string',
                'height'    => 'nullable|string',
                'weight'    => 'required|string',
            ]);
        } elseif ($request->input('predefined_package') == null) {
            $request->validate([
                'parcel'    => 'required|string',
            ]);
        } elseif ($request->input('parcel') == null) {
            $request->validate([
                'predefined_package'    => 'required|string',
                'weight'                => 'required|string'
            ]);
        }

        $client = new EasyPostClient($request->session()->get('apiKey'));

        if ($request->input('to_address') != null) {
            try {
                $toAddress = $client->address->retrieve($request->input('to_address'));
            } catch (ApiException $exception) {
                return back()->withError($exception->getMessage());
            }
        } else {
            $toAddress = [
                'name'      => $request->input('to_name'),
                'company'   => $request->input('to_company'),
                'street1'   => $request->input('to_street1'),
                'street2'   => $request->input('to_street2'),
                'city'      => $request->input('to_city'),
                'state'     => $request->input('to_state'),
                'zip'       => $request->input('to_zip'),
                'country'   => $request->input('to_country'),
                'phone'     => $request->input('to_phone'),
                'email'     => $request->input('to_email'),
            ];
        }

        if ($request->input('from_address') != null) {
            try {
                $fromAddress = $client->address->retrieve($request->input('from_address'));
            } catch (ApiException $exception) {
                return back()->withError($exception->getMessage());
            }
        } else {
            $fromAddress = [
                'name'      => $request->input('from_name'),
                'company'   => $request->input('from_company'),
                'street1'   => $request->input('from_street1'),
                'street2'   => $request->input('from_street2'),
                'city'      => $request->input('from_city'),
                'state'     => $request->input('from_state'),
                'zip'       => $request->input('from_zip'),
                'country'   => $request->input('from_country'),
                'phone'     => $request->input('from_phone'),
                'email'     => $request->input('from_email'),
            ];
        }

        if ($request->input('parcel') != null) {
            try {
                $parcel = $client->parcel->retrieve($request->input('parcel'));
            } catch (ApiException $exception) {
                return back()->withError($exception->getMessage());
            }
        } elseif ($request->input('predefined_package') != null) {
            try {
                $parcel = $client->parcel->create([
                    'predefined_package'    => $request->input('predefined_package'),
                    'weight'                => $request->input('weight'),
                ]);
            } catch (ApiException $exception) {
                return back()->withError($exception->getMessage());
            }
        } else {
            $parcel = [
                'length'    => $request->input('length'),
                'width'     => $request->input('width'),
                'height'    => $request->input('height'),
                'weight'    => $request->input('weight'),
            ];
        }

        try {
            $shipment = $client->shipment->create(
                [
                    'to_address'    => $toAddress,
                    'from_address'  => $fromAddress,
                    'parcel'        => $parcel
                ]
            );
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        $rates = $shipment->rates;

        usort(
            $rates,
            function ($a, $b) {
                return $a->rate < $b->rate ? -1 : 1;
            }
        );

        return redirect("shipments/$shipment->id");
    }

    /**
     * Retrieve a Shipment.
     *
     * @param Request $request
     * @param string $id
     * @return View|RedirectResponse
     */
    public function retrieveShipment(Request $request, string $id): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $shipment = $client->shipment->retrieve($id);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('shipment')->with(['shipment' => $shipment, 'rates' => $shipment->rates ?? []]);
    }

    /**
     * Retrieve a list of Shipment objects.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function retrieveShipments(Request $request): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $shipments = $client->shipment->all([
                'purchased' => false,
            ]);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('shipments')->with(['json' => $shipments]);
    }

    /**
     * Refund a Shipment.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function refundShipment(Request $request, string $id): RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $client->shipment->refund($id);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'Refund submitted! Follow-up with the carrier for more details.');
        return back();
    }

    /**
     * Buy a Shipment.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function buyShipment(Request $request, string $id): RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $shipment = $client->shipment->buy(
                $id,
                ['rate' => ['id' => $request->input('rate_id')]],
            );
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'Shipment bought!');
        return redirect("shipments/$shipment->id");
    }

    /**
     * Buy a USPS stamp (will produce an A10 envelope label with the stamp/barcode included).
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function buyStamp(Request $request): RedirectResponse
    {
        if ($request->input('to_address') == null) {
            $request->validate([
                'to_name'       => 'nullable|string',
                'to_company'    => 'nullable|string',
                'to_street1'    => 'required|string',
                'to_street2'    => 'nullable|string',
                'to_city'       => 'nullable|string',
                'to_state'      => 'nullable|string',
                'to_zip'        => 'required|string',
            ]);
        } else {
            $request->validate([
                'to_address'    => 'required|string',
            ]);
        }

        if ($request->input('from_address') == null) {
            $request->validate([
                'from_name'       => 'nullable|string',
                'from_company'    => 'nullable|string',
                'from_street1'    => 'required|string',
                'from_street2'    => 'nullable|string',
                'from_city'       => 'nullable|string',
                'from_state'      => 'nullable|string',
                'from_zip'        => 'required|string',
            ]);
        } else {
            $request->validate([
                'from_address'  => 'required|string',
            ]);
        }

        $client = new EasyPostClient($request->session()->get('apiKey'));

        if ($request->input('to_address') != null) {
            try {
                $toAddress = $client->address->retrieve($request->input('to_address'));
            } catch (ApiException $exception) {
                return back()->withError($exception->getMessage());
            }
        } else {
            $toAddress = [
                'name'      => $request->input('to_name'),
                'company'   => $request->input('to_company'),
                'street1'   => $request->input('to_street1'),
                'street2'   => $request->input('to_street2'),
                'city'      => $request->input('to_city'),
                'state'     => $request->input('to_state'),
                'zip'       => $request->input('to_zip'),
            ];
        }

        if ($request->input('from_address') != null) {
            try {
                $fromAddress = $client->address->retrieve($request->input('from_address'));
            } catch (ApiException $exception) {
                return back()->withError($exception->getMessage());
            }
        } else {
            $fromAddress = [
                'name'      => $request->input('from_name'),
                'company'   => $request->input('from_company'),
                'street1'   => $request->input('from_street1'),
                'street2'   => $request->input('from_street2'),
                'city'      => $request->input('from_city'),
                'state'     => $request->input('from_state'),
                'zip'       => $request->input('from_zip'),
            ];
        }

        $parcel = [
            'predefined_package'    => 'Letter',
            'weight'                => 1,
        ];

        try {
            $carrierAccounts = $client->carrierAccount->all();
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        // Naive approach of grabbing the first USPS carrier account, this is not intended to be robust but convenient
        // We also call this out on the frontend so the user knows
        foreach ($carrierAccounts as $carrierAccount) {
            if ($carrierAccount->type == 'UspsAccount') {
                $usps = $carrierAccount;
                break;
            } else {
                $usps = null;
            }
        }

        if (!isset($usps)) {
            return back()->withError('No USPS carrier account found!');
        }

        try {
            $shipment = $client->shipment->create(
                [
                    'to_address'        => $toAddress,
                    'from_address'      => $fromAddress,
                    'parcel'            => $parcel,
                    'service'           => 'GroundAdvantage',
                    'carrier_accounts'  => [$usps->id],
                ]
            );
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'Stamp bought!');
        return redirect("/shipments/$shipment->id");
    }

    /**
     * Generate QR Codes for a Shipment.
     *
     * @param Request $request
     * @param string $id
     * @return View|RedirectResponse
     */
    public function generateQrCodes(Request $request, string $id): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $shipment = $client->shipment->generateForm($id, 'label_qr_code');
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        session()->flash('message', 'QR code generated!');
        return redirect("/shipments/$shipment->id");
    }
}
