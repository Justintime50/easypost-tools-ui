<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Update the API key on the user's account.
     *
     * @param Request $request
     * @return mixed
     */
    public function updateApiKey(Request $request): RedirectResponse
    {
        $request->validate([
            'api_key' => 'required|string',
        ]);

        $user = User::find(Auth::user()->id);
        $user->api_key = Crypt::encryptString($request->input('api_key'));
        $user->save();

        session()->flash('message', 'API Key updated');
        return back();
    }
}
