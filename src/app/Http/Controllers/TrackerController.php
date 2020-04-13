<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \EasyPost\EasyPost;
use \EasyPost\Tracker;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class TrackerController extends Controller
{
    /**
     * Create a tracker
     *
     * @param Request $request
     * @return mixed
     */
    public function createTracker(Request $request)
    {
        // Decrypt stored API Key
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);

        request()->validate([
            "tracking_code" => "required|string",
            "carrier"       => "nullable|string",
        ]);

        try {
            $tracker = Tracker::create(
                array(
                    "tracking_code"  => request()->get("tracking_code"),
                    "carrier" => request()->get("carrier"),
                )
            );
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $tracker;

        session()->flash("message", "TRACKER CREATED");
        return redirect("/")->with(["response" => $response]);
    }

    /**
     * Retrieve a tracker
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveTracker(Request $request)
    {
        // Decrypt stored API Key
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);

        try {
            $tracker = Tracker::retrieve(request()->get("id"));
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $tracker;

        session()->flash("message", "TRACKER RETRIEVED");
        return view("app")->with(["json" => $response]);
    }

    /**
     * Retrieve a list of trackers
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveTrackers(Request $request)
    {
        // Decrypt stored API Key
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);

        try {
            $trackers = Tracker::all();
        } catch (\EasyPost\Error $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $response = $trackers;
        $json = json_decode($response); 

        session()->flash("message", "TRACKERS RETRIEVED");
        return view("trackers")->with(["json" => $json]);
    }
}
