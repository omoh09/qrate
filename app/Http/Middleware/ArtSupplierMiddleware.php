<?php

namespace App\Http\Middleware;

use Closure;

class ArtSupplierMiddleware
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
        if(auth()->user()->role == 4)
        {
            return $next($request);
        }
        return response()->json(['message' => 'feature not supported for this account'],403);
    }
}
