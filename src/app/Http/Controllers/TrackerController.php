<?php

namespace App\Http\Controllers;

use EasyPost\Tracker;

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

        try {
            $response = Tracker::create(
                [
                    'tracking_code'  => request()->get('tracking_code'),
                    'carrier' => request()->get('carrier'),
                ]
            );
        } catch (\EasyPost\Error $exception) {
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
        try {
            $tracker = Tracker::retrieve($id);
        } catch (\EasyPost\Error $exception) {
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
        try {
            $response = Tracker::all();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        session()->flash('message', 'TRACKERS RETRIEVED');
        return view('trackers')->with(['json' => $response]);
    }
}
