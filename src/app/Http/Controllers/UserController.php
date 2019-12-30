<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use \App\Models\User;

class UserController extends Controller
{
    /**
     * updateApiKey
     *
     * @param Request $request
     * @return void
     */
    public function updateApiKey(Request $request)
    {
        request()->validate([
            'api_key' => 'required|string',
        ]);

        $api_key = User::find(Auth::user()->id);
        $api_key_hash = Hash::make(request()->get('api_key'));
        $api_key->api_key = $api_key_hash;
        $api_key->save();

        session()->flash("message", "API KEY UPDATED");
        return redirect()->back();
    }
}
