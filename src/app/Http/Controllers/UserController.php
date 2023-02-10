<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Update the API key on the user's account.
     *
     * @return mixed
     */
    public function updateApiKey()
    {
        request()->validate([
            'api_key' => 'required|string',
        ]);

        $user = User::find(Auth::user()->id);
        $user->api_key = Crypt::encryptString(request()->get('api_key'));
        $user->save();

        session()->flash('message', 'API KEY UPDATED');
        return redirect()->back();
    }
}
