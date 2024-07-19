<?php

namespace App\Http\Controllers;

use EasyPost\EasyPostClient;
use EasyPost\Exception\Api\ApiException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Retrieve an Refund.
     *
     * @param Request $request
     * @param string $id
     * @return View|RedirectResponse
     */
    public function retrieveRefund(Request $request, string $id)
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $refund = $client->refund->retrieve($id);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('record')->with(['json' => $refund]);
    }

    /**
     * Retrieve a list of Refunds.
     *
     * You can't actually retrieve a list of Refunds, there is no EasyPost endpoint for this,
     * so we just return the refunds page.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function retrieveRefunds(Request $request): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $refunds = $client->refund->all();
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('refunds')->with(['json' => $refunds]);
    }
}
