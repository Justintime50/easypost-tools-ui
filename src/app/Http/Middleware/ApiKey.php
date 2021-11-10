<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use EasyPost\EasyPost;

class ApiKey
{
    /**
     * Use EasyPost API Key in requests
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        request()->validate([
            "api_key"    => "required|string",
        ]);

        EasyPost::setApiKey(request()->get("api_key"));

        return $next($request);
    }
}
