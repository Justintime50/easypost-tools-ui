<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class ApiKey
{
    /**
     * Decrypt stored API Key
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        try {
            $apiKey = Crypt::decryptString(auth()->user()->api_key);
        } catch (DecryptException $e) {
            session()->flash('error', 'API key could not be decrypted. Please update your API key and try again.');
            return back();
        }

        $request->session()->put('apiKey', $apiKey);

        return $next($request);
    }
}
