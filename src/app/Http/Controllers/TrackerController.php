<?php

namespace App\Http\Controllers;

use EasyPost\EasyPostClient;
use EasyPost\Exception\Api\ApiException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    /**
     * Create a Tracker.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function createTracker(Request $request): View|RedirectResponse
    {
        $request->validate([
            'tracking_code' => 'required|string',
            'carrier'       => 'nullable|string',
        ]);

        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $tracker = $client->tracker->create(
                [
                    'tracking_code'  => $request->input('tracking_code'),
                    'carrier' => $request->input('carrier'),
                ]
            );
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return redirect("trackers/$tracker->id");
    }

    /**
     * Retrieve a Tracker.
     *
     * @param Request $request
     * @param string $id
     * @return View|RedirectResponse
     */
    public function retrieveTracker(Request $request, string $id): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $tracker = $client->tracker->retrieve($id);
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('record')->with(['json' => $tracker]);
    }

    /**
     * Retrieve a list of Tracker objects.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function retrieveTrackers(Request $request): View|RedirectResponse
    {
        $client = new EasyPostClient($request->session()->get('apiKey'));

        try {
            $response = $client->tracker->all();
        } catch (ApiException $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('trackers')->with(['json' => $response]);
    }
}
