<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class UserMiddleware
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
        if(Auth::user()->approvedByAdmin != 1){
          return redirect()->route('login')->withErrors(['email' => 'User not approved by admin']);;
        }
        if(auth::check() && Auth::user()->type == 2){
            return $next($request);
        }
        else {
            return redirect()->route('login');
        }
    }
}
