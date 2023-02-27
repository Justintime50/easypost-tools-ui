<?php

namespace App\Http\Middleware;

use Closure;
use EasyPost\EasyPostClient;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $apiKey = Crypt::decryptString(Auth::user()->api_key);
        } catch (DecryptException $e) {
            session()->flash('error', 'API Key could not be decrypted. Please update your key and try again.');
            return back();
        }

        $client = new EasyPostClient($apiKey);
        $request->session()->put(['client' => $client]);

        return $next($request);
    }
}
