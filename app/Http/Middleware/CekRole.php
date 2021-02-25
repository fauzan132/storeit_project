<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CekRole
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
        if (Auth::user() &&  Auth::user()->role == "Admin" || Auth::user()->role == "Expert ITB" || Auth::user()->role == "Expert BALITSA" || Auth::user()->role == "Expert EWINDO" || Auth::user()->role == "Cropper") {
            return $next($request);
        }

       return redirect('permission')->with('error','You have not admin access');
    }



}
