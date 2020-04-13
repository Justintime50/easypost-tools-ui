<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use \EasyPost\EasyPost;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class ApiKey
{
    /**
     * Decrypt stored API Key
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $api_key = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash("error", "API KEY COULD NOT BE DECRYPTED. PLEASE UPDATE YOUR KEY.");
            return redirect()->back();
        }
        EasyPost::setApiKey($api_key);
    }
}
