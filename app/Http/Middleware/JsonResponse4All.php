<?php

namespace App\Http\Middleware;

use Closure;

class JsonResponse4All
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
        /***
         * This Middleware takes care of making sure that
         * all returned output is returned in JSON.
         */
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
