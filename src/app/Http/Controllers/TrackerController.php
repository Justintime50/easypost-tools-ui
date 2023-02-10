<?php

namespace App\Http\Controllers;

use EasyPost\Exception\General\EasyPostException;

class TrackerController extends Controller
{
    /**
     * Create a Tracker.
     *
     * @return mixed
     */
    public function createTracker()
    {
        request()->validate([
            'tracking_code' => 'required|string',
            'carrier'       => 'nullable|string',
        ]);

        $client = request()->get('client');

        try {
            $response = $client->tracker->create(
                [
                    'tracking_code'  => request()->get('tracking_code'),
                    'carrier' => request()->get('carrier'),
                ]
            );
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'TRACKER CREATED');
        return redirect('/')->with(['json' => $response]);
    }

    /**
     * Retrieve a Tracker.
     *
     * @param string $id
     * @return mixed
     */
    public function retrieveTracker(string $id)
    {
        $client = request()->get('client');

        try {
            $tracker = $client->tracker->retrieve($id);
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $tracker;

        session()->flash('message', 'TRACKER RETRIEVED');
        return view('app')->with(['json' => $response]);
    }

    /**
     * Retrieve a list of Tracker objects.
     *
     * @return mixed
     */
    public function retrieveTrackers()
    {
        $client = request()->get('client');

        try {
            $response = $client->tracker->all();
        } catch (EasyPostException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'TRACKERS RETRIEVED');
        return view('trackers')->with(['json' => $response]);
    }
}
