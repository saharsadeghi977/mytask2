<?php

namespace App\Http\Middleware;

use App\Services\CoreServices;
use Closure;
use Illuminate\Http\Request;

class SetUserMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        CoreServices::$userToken = str_replace("Bearer ", "", $request->header("Authorization"));
        return $next($request);
    }
}
