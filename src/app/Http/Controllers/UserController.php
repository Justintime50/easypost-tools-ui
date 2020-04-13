<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Update the API key on the user's account
     *
     * @param Request $request
     * @return mixed
     */
    public function updateApiKey(Request $request)
    {
        request()->validate([
            'api_key' => 'required|string',
        ]);

        $user = User::find(Auth::user()->id);
        $user->api_key = Crypt::encryptString(request()->get('api_key'));
        $user->save();

        session()->flash("message", "API KEY UPDATED");
        return redirect()->back();
    }
}
