<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;

class RoleMiddleware
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
        if(auth()->user()->role == 1 || auth()->user()->role == 4 ){
            return Helper::response('error','feature not supported for this account',403);
        }else{
            return $next($request);
        }
    }
}
