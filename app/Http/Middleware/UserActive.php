<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;

class UserActive
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
        if(auth()->user()->active)
        {
            return $next($request);
        }else{
            return Helper::response('error','user account has been deactivated',401);
        }
    }
}
