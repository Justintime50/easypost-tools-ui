<?php

namespace App\Http\Controllers;

use EasyPost\Exception\General\EasyPostException;

const OBJECT_ID_PREFIXES = [
    'adr'       => 'address',
    'ak'        => 'apikey',
    'batch'     => 'batch',
    'brd'       => 'brand',
    'ca'        => 'carrierAccount',
    'cstinfo'   => 'customsInfo',
    'cstitem'   => 'customsItem',
    'es'        => 'endShipper',
    'evt'       => 'event',
    'fee'       => 'fee',
    'hook'      => 'webhook',
    'ins'       => 'insurance',
    'order'     => 'order',
    'pickup'    => 'pickup',
    'pl'        => 'postageLabel',
    'plrep'     => 'report',
    'prcl'      => 'parcel',
    'rate'      => 'rate',
    'refrep'    => 'report',
    'rfnd'      => 'refund',
    'sf'        => 'scanForm',
    'shp'       => 'shipment',
    'shpinvrep' => 'report',
    'shprep'    => 'report',
    'trk'       => 'tracker',
    'trkrep'    => 'report',
    'user'      => 'user',
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
        $client = request()->get('client');

        try {
            $response = $client->{OBJECT_ID_PREFIXES[$idPrefix]}->retrieve($id);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage());
        }

        return redirect('/')->with(['json' => $response]);
    }
}
