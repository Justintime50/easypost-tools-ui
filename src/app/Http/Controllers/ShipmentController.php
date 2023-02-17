<?php

namespace App\Http\Controllers;

use EasyPost\Exception\General\EasyPostException;

class ShipmentController extends Controller
{
    /**
     * Create a Shipment.
     *
     * @return mixed
     */
    public function createShipment()
    {
        if (request()->get('to_address') == null) {
            request()->validate([
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
            request()->validate([
                'to_address'    => 'required|string',
            ]);
        }

        if (request()->get('from_address') == null) {
            request()->validate([
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
            request()->validate([
                'from_address'  => 'required|string',
            ]);
        }

        if (request()->get('parcel') != null && request()->get('predefined_package') != null) {
            return back()->withError('Either a Parcel ID or a predefined package may be specified, not both.')->withInput();
        }

        if (request()->get('parcel') == null && request()->get('predefined_package') == null) {
            request()->validate([
                'length'    => 'nullable|string',
                'width'     => 'nullable|string',
                'height'    => 'nullable|string',
                'weight'    => 'required|string',
            ]);
        } elseif (request()->get('predefined_package') == null) {
            request()->validate([
                'parcel'    => 'required|string',
            ]);
        } elseif (request()->get('parcel') == null) {
            request()->validate([
                'predefined_package'    => 'required|string',
                'weight'                => 'required|string'
            ]);
        }

        $client = request()->get('client');

        if (request()->get('to_address') != null) {
            try {
                $toAddress = $client->address->retrieve(request()->get('to_address'));
            } catch (EasyPostException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } else {
            $toAddress = [
                'name'      => request()->get('to_name'),
                'company'   => request()->get('to_company'),
                'street1'   => request()->get('to_street1'),
                'street2'   => request()->get('to_street2'),
                'city'      => request()->get('to_city'),
                'state'     => request()->get('to_state'),
                'zip'       => request()->get('to_zip'),
                'country'   => request()->get('to_country'),
                'phone'     => request()->get('to_phone'),
                'email'     => request()->get('to_email'),
            ];
        }

        if (request()->get('from_address') != null) {
            try {
                $fromAddress = $client->address->retrieve(request()->get('from_address'));
            } catch (EasyPostException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } else {
            $fromAddress = [
                'name'      => request()->get('from_name'),
                'company'   => request()->get('from_company'),
                'street1'   => request()->get('from_street1'),
                'street2'   => request()->get('from_street2'),
                'city'      => request()->get('from_city'),
                'state'     => request()->get('from_state'),
                'zip'       => request()->get('from_zip'),
                'country'   => request()->get('from_country'),
                'phone'     => request()->get('from_phone'),
                'email'     => request()->get('from_email'),
            ];
        }

        if (request()->get('parcel') != null) {
            try {
                $parcel = $client->parcel->retrieve(request()->get('parcel'));
            } catch (EasyPostException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } elseif (request()->get('predefined_package') != null) {
            try {
                $parcel = $client->parcel->create([
                    'predefined_package'    => request()->get('predefined_package'),
                    'weight'                => request()->get('weight'),
                ]);
            } catch (EasyPostException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } else {
            $parcel = [
                'length'    => request()->get('length'),
                'width'     => request()->get('width'),
                'height'    => request()->get('height'),
                'weight'    => request()->get('weight'),
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
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;
        $json = json_decode($response);

        $rates = $shipment->rates;

        usort(
            $rates,
            function ($a, $b) {
                return $a->rate < $b->rate ? -1 : 1;
            }
        );

        session()->flash('message', 'SHIPMENT CREATED');
        return view('rates')->with(['json' => $json, 'rates' => $rates]);
    }

    /**
     * Retrieve a Shipment.
     *
     * @param string $id
     * @return mixed
     */
    public function retrieveShipment(string $id)
    {
        $client = request()->get('client');

        try {
            $response = $client->shipment->retrieve($id);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'SHIPMENT RETRIEVED');
        return view('app')->with(['json' => $response]);
    }

    /**
     * Retrieve a list of Shipment objects.
     *
     * @return mixed
     */
    public function retrieveShipments()
    {
        $client = request()->get('client');

        try {
            $shipments = $client->shipment->all([
                'purchased' => false
            ]);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipments;
        $json = json_decode($response);

        session()->flash('message', 'SHIPMENTS RETRIEVED');
        return view('shipments')->with(['json' => $json]);
    }

    /**
     * Refund a Shipment.
     *
     * @return mixed
     */
    public function createRefund()
    {
        $client = request()->get('client');

        try {
            $shipment = $client->shipment->retrieve(request()->get('id'));
            $shipment->refund();
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'SHIPMENT REFUNDED');
        return redirect('/')->with(['json' => $shipment]);
    }

    /**
     * Buy a Shipment.
     *
     * @return mixed
     */
    public function buyShipment()
    {
        $client = request()->get('client');

        try {
            $shipment = $client->shipment->retrieve(request()->get('shipment_id'));
            $boughtShipment = $client->shipment->buy(
                $shipment->id,
                ['id' => request()->get('rate_id')],
            );
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'LABEL PURCHASED');
        return redirect('/')->with(['json' => $boughtShipment]);
    }

    /**
     * Buy a USPS stamp (will produce an A10 envelope label with the stamp/barcode included).
     *
     * @return mixed
     */
    public function buyStamp()
    {
        if (request()->get('to_address') == null) {
            request()->validate([
                'to_street1'    => 'required|string',
                'to_street2'    => 'nullable|string',
                'to_city'       => 'nullable|string',
                'to_state'      => 'nullable|string',
                'to_zip'        => 'required|string',
                'to_company'    => 'nullable|string',
                'to_phone'      => 'nullable|string',
            ]);
        } else {
            request()->validate([
                'to_address'    => 'required|string',
            ]);
        }

        if (request()->get('from_address') == null) {
            request()->validate([
                'from_street1'   => 'required|string',
                'from_street2'   => 'nullable|string',
                'from_city'      => 'nullable|string',
                'from_state'     => 'nullable|string',
                'from_zip'       => 'required|string',
                'from_company'   => 'nullable|string',
                'from_phone'     => 'nullable|string',
            ]);
        } else {
            request()->validate([
                'from_address'  => 'required|string',
            ]);
        }

        $client = request()->get('client');

        if (request()->get('to_address') != null) {
            try {
                $toAddress = $client->address->retrieve(request()->get('to_address'));
            } catch (EasyPostException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } else {
            $toAddress = [
                'street1' => request()->get('to_street1'),
                'street2' => request()->get('to_street2'),
                'city'    => request()->get('to_city'),
                'state'   => request()->get('to_state'),
                'zip'     => request()->get('to_zip'),
                'country' => 'United States',
                'company' => request()->get('to_company'),
                'phone'   => request()->get('to_phone'),
            ];
        }

        if (request()->get('from_address') != null) {
            try {
                $fromAddress = $client->address->retrieve(request()->get('from_address'));
            } catch (EasyPostException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        } else {
            $fromAddress = [
                'street1' => request()->get('from_street1'),
                'street2' => request()->get('from_street2'),
                'city'    => request()->get('from_city'),
                'state'   => request()->get('from_state'),
                'zip'     => request()->get('from_zip'),
                'country' => 'United States',
                'company' => request()->get('from_company'),
                'phone'   => request()->get('from_phone'),
            ];
        }

        $parcel = [
            'predefined_package'    => 'Letter',
            'weight'                => 1,
        ];

        try {
            $carrierAccounts = $client->carrierAccount->all();
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
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

        try {
            $shipment = $client->shipment->create(
                [
                    'to_address'        => $toAddress,
                    'from_address'      => $fromAddress,
                    'parcel'            => $parcel,
                    'service'           => 'First',
                    'carrier_accounts'  => [$usps->id],
                ]
            );
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'USPS STAMP BOUGHT');
        return redirect('/')->with(['json' => $shipment]);
    }
}
