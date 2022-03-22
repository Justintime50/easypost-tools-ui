<?php

namespace App\Http\Controllers;

use EasyPost\Address;
use EasyPost\CarrierAccount;
use EasyPost\Parcel;
use EasyPost\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Create a shipment
     *
     * @return mixed
     */
    public function createShipment()
    {
        if (request()->get("to_address") == null) {
            request()->validate([
                "to_street1"    => "required|string",
                "to_street2"    => "nullable|string",
                "to_city"       => "nullable|string",
                "to_state"      => "nullable|string",
                "to_zip"        => "required|string",
                "to_country"    => "nullable|string",
                "to_company"    => "nullable|string",
                "to_phone"      => "nullable|string",
            ]);
        } else {
            request()->validate([
                "to_address"    => "required|string",
            ]);
        }

        if (request()->get("from_address") == null) {
            request()->validate([
                "from_street1"   => "required|string",
                "from_street2"   => "nullable|string",
                "from_city"      => "nullable|string",
                "from_state"     => "nullable|string",
                "from_zip"       => "required|string",
                "from_country"   => "nullable|string",
                "from_company"   => "nullable|string",
                "from_phone"     => "nullable|string",
            ]);
        } else {
            request()->validate([
                "from_address"  => "required|string",
            ]);
        }

        if (request()->get("parcel") != null && request()->get("predefined_package") != null) {
            return back()->withError("Either a Parcel ID or a predefined package may be specified, not both.")->withInput();
        }

        if (request()->get("parcel") == null && request()->get("predefined_package") == null) {
            request()->validate([
                "length"    => "nullable|string",
                "width"     => "nullable|string",
                "height"    => "nullable|string",
                "weight"    => "required|string",
            ]);
        } elseif (request()->get("predefined_package") == null) {
            request()->validate([
                "parcel"    => "required|string",
            ]);
        } elseif (request()->get("parcel") == null) {
            request()->validate([
                "predefined_package"    => "required|string",
                "weight"                => "required|string"
            ]);
        }

        try {
            if (request()->get("to_address") != null) {
                $to_address = Address::retrieve(request()->get("to_address"));
            } else {
                $to_address = [
                    "street1" => request()->get("to_street1"),
                    "street2" => request()->get("to_street2"),
                    "city"    => request()->get("to_city"),
                    "state"   => request()->get("to_state"),
                    "zip"     => request()->get("to_zip"),
                    "country" => request()->get("to_country"),
                    "company" => request()->get("to_company"),
                    "phone"   => request()->get("to_phone"),
                ];
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        try {
            if (request()->get("from_address") != null) {
                $from_address = Address::retrieve(request()->get("from_address"));
            } else {
                $from_address = [
                    "street1" => request()->get("from_street1"),
                    "street2" => request()->get("from_street2"),
                    "city"    => request()->get("from_city"),
                    "state"   => request()->get("from_state"),
                    "zip"     => request()->get("from_zip"),
                    "country" => request()->get("from_country"),
                    "company" => request()->get("from_company"),
                    "phone"   => request()->get("from_phone"),
                ];
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        try {
            if (request()->get("parcel") != null) {
                $parcel = Parcel::retrieve(request()->get("parcel"));
            } elseif (request()->get("predefined_package") != null) {
                $parcel = Parcel::create([
                    "predefined_package"    => request()->get("predefined_package"),
                    "weight"                => request()->get("weight"),
                ]);
            } else {
                $parcel = [
                    "length"    => request()->get("length"),
                    "width"     => request()->get("width"),
                    "height"    => request()->get("height"),
                    "weight"    => request()->get("weight"),
                ];
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        try {
            $shipment = Shipment::create(
                [
                    "to_address"    => $to_address,
                    "from_address"  => $from_address,
                    "parcel"        => $parcel
                ]
            );
        } catch (\EasyPost\Error $exception) {
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

        session()->flash("message", "SHIPMENT CREATED");
        return view("rates")->with(["json" => $json, "rates" => $rates]);
    }

    /**
     * Retrieve a shipment
     *
     * @return mixed
     */
    public function retrieveShipment()
    {
        try {
            $shipment = Shipment::retrieve(request()->get("id"));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT RETRIEVED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * Retrieve a list of shipments
     *
     * @return mixed
     */
    public function retrieveShipments()
    {
        try {
            $shipments = Shipment::all([
                "purchased" => false
            ]);
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipments;
        $json = json_decode($response);

        session()->flash("message", "SHIPMENTS RETRIEVED");
        return view("shipments")->with(["json" => $json]);
    }

    /**
     * Refund a shipment
     *
     * @return mixed
     */
    public function createRefund()
    {
        try {
            $shipment = Shipment::retrieve(request()->get("id"));
            $shipment->refund();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "SHIPMENT REFUNDED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * Buy a Shipment
     *
     * @return mixed
     */
    public function buyShipment()
    {
        try {
            $shipment = Shipment::retrieve(request()->get("shipment_id"));
            $shipment->buy([
                "id" => request()->get("rate_id"),
            ]);
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $shipment;

        session()->flash("message", "LABEL PURCHASED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * Buy a USPS stamp (will produce an A10 envelope label with the stamp/barcode included)
     *
     * @return mixed
     */
    public function buyStamp()
    {
        if (request()->get("to_address") == null) {
            request()->validate([
                "to_street1"    => "required|string",
                "to_street2"    => "nullable|string",
                "to_city"       => "nullable|string",
                "to_state"      => "nullable|string",
                "to_zip"        => "required|string",
                "to_company"    => "nullable|string",
                "to_phone"      => "nullable|string",
            ]);
        } else {
            request()->validate([
                "to_address"    => "required|string",
            ]);
        }

        if (request()->get("from_address") == null) {
            request()->validate([
                "from_street1"   => "required|string",
                "from_street2"   => "nullable|string",
                "from_city"      => "nullable|string",
                "from_state"     => "nullable|string",
                "from_zip"       => "required|string",
                "from_company"   => "nullable|string",
                "from_phone"     => "nullable|string",
            ]);
        } else {
            request()->validate([
                "from_address"  => "required|string",
            ]);
        }

        if (request()->get("parcel") != null && request()->get("predefined_package") != null) {
            return back()->withError("Either a Parcel ID or a predefined package may be specified, not both.")->withInput();
        }

        try {
            if (request()->get("to_address") != null) {
                $to_address = Address::retrieve(request()->get("to_address"));
            } else {
                $to_address = [
                    "street1" => request()->get("to_street1"),
                    "street2" => request()->get("to_street2"),
                    "city"    => request()->get("to_city"),
                    "state"   => request()->get("to_state"),
                    "zip"     => request()->get("to_zip"),
                    "country" => 'United States',
                    "company" => request()->get("to_company"),
                    "phone"   => request()->get("to_phone"),
                ];
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        try {
            if (request()->get("from_address") != null) {
                $from_address = Address::retrieve(request()->get("from_address"));
            } else {
                $from_address = [
                    "street1" => request()->get("from_street1"),
                    "street2" => request()->get("from_street2"),
                    "city"    => request()->get("from_city"),
                    "state"   => request()->get("from_state"),
                    "zip"     => request()->get("from_zip"),
                    "country" => 'United States',
                    "company" => request()->get("from_company"),
                    "phone"   => request()->get("from_phone"),
                ];
            }
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $parcel = [
            "predefined_package"    => 'Letter',
            "weight"                => 1,
        ];

        // Naive approach of grabbing the first USPS carrier account, this is not intended to be robust but convenient
        // We also call this out on the frontend so the user knows
        $carrier_accounts = CarrierAccount::all();
        foreach ($carrier_accounts as $carrier_account) {
            if ($carrier_account->type == 'UspsAccount') {
                $usps = $carrier_account;
                break;
            } else {
                $usps = null;
            }
        }

        try {
            $shipment = Shipment::create(
                [
                    "to_address"        => $to_address,
                    "from_address"      => $from_address,
                    "parcel"            => $parcel,
                    "service"           => 'First',
                    'carrier_accounts'  => [$usps->id],
                ]
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash("message", "USPS STAMP BOUGHT");
        return view("app")->with(["json" => $shipment]);
    }
}
