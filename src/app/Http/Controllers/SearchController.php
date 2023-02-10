<?php

namespace App\Http\Controllers;

use EasyPost;
use EasyPost\Exception\General\EasyPostException;

const OBJECT_ID_PREFIXES = [
    'adr'       => EasyPost\Address::class,
    'ak'        => EasyPost\ApiKey::class,
    'batch'     => EasyPost\Batch::class,
    'brd'       => EasyPost\Brand::class,
    'ca'        => EasyPost\CarrierAccount::class,
    'cstinfo'   => EasyPost\CustomsInfo::class,
    'cstitem'   => EasyPost\CustomsItem::class,
    'es'        => EasyPost\EndShipper::class,
    'evt'       => EasyPost\Event::class,
    'fee'       => EasyPost\Fee::class,
    'hook'      => EasyPost\Webhook::class,
    'ins'       => EasyPost\Insurance::class,
    'order'     => EasyPost\Order::class,
    'pickup'    => EasyPost\Pickup::class,
    'pl'        => EasyPost\PostageLabel::class,
    'plrep'     => EasyPost\Report::class,
    'prcl'      => EasyPost\Parcel::class,
    'rate'      => EasyPost\Rate::class,
    'refrep'    => EasyPost\Report::class,
    'rfnd'      => EasyPost\Refund::class,
    'sf'        => EasyPost\ScanForm::class,
    'shp'       => EasyPost\Shipment::class,
    'shpinvrep' => EasyPost\Report::class,
    'shprep'    => EasyPost\Report::class,
    'trk'       => EasyPost\Tracker::class,
    'trkrep'    => EasyPost\Report::class,
    'user'      => EasyPost\User::class,
];

class SearchController extends Controller
{
    /**
     * Search for an EasyPost object by passing an EasyPost object public ID.
     *
     * @return mixed
     */
    public function searchRecord()
    {
        $id = request()->get('id');
        $idPrefix = substr($id, 0, strpos($id, '_'));

        try {
            $response = OBJECT_ID_PREFIXES[$idPrefix]::retrieve($id);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return to_route('app')->with(['json' => $response]);
    }
}
