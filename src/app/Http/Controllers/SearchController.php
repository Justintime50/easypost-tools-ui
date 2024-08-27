<?php

namespace App\Http\Controllers;

use EasyPost\EasyPostClient;
use EasyPost\Exception\Api\ApiException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

const OBJECT_ID_PREFIXES = [
    'adr'       => 'address',
    'batch'     => 'batch',
    'ca'        => 'carrierAccount',
    'cstinfo'   => 'customsInfo',
    'cstitem'   => 'customsItem',
    'es'        => 'endShipper',
    'evt'       => 'event',
    'hook'      => 'webhook',
    'ins'       => 'insurance',
    'order'     => 'order',
    'pickup'    => 'pickup',
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
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function searchRecord(Request $request): View|RedirectResponse
    {
        $id = $request->input('id');
        $idPrefix = substr($id, 0, strpos($id, '_'));
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $class = OBJECT_ID_PREFIXES[$idPrefix] ?? null;
            if ($class == null) {
                return back()->withError('Invalid EasyPost ID supplied, please try again.');
            } else {
                $response = $client->{$class}->retrieve($id);
            }
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('record')->with(['json' => $response]);
    }
}
