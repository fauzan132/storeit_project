<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CekAdmin
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
        if (Auth::user() &&  Auth::user()->role == "Admin") {
            return $next($request);
        }

       return redirect('permission')->with('error','You have not admin access');
    }
}
