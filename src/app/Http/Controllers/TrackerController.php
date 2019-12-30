<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
use \EasyPost\Tracker;

EasyPost::setApiKey(env('EASYPOST_API_KEY'));

class TrackerController extends Controller
{
    /**
     * createTracker
     *
     * @param Request $request
     * @return void
     */
    public function createTracker(Request $request)
    {
        request()->validate([
            'tracking_code' => 'required|string',
            # 'carrier'       => 'required|string',
        ]);

        try {
            $tracker = Tracker::create(
                array(
                    "tracking_code"  => request()->get('tracking_code'),
                    # "carrier" => request()->get('carrier'),
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $tracker;

        session()->flash("message", "TRACKER CREATED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * retrieveTracker
     *
     * @param Request $request
     * @return void
     */
    public function retrieveTracker(Request $request)
    {
        try {
            $tracker = Tracker::retrieve(request()->get('id'));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $tracker;

        session()->flash("message", "TRACKER RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }

    /**
     * retrieveTrackers
     *
     * @param Request $request
     * @return void
     */
    public function retrieveTrackers(Request $request)
    {
        try {
            $trackers = Tracker::all(array(
                # "page_size" => 2,
                # "start_datetime" => "2016-01-02T08:50:00Z"
              ));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $trackers;

        session()->flash("message", "TRACKERS RETRIEVED");
        return redirect()->back()->with(['response' => $response]);
    }
}
