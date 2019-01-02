<?php

namespace App\Http\Middleware;

use Closure;
use App\Extensions\Helpers;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        Helpers::loggingRoute($request);
    }
}
