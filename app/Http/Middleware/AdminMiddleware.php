<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
       // if (empty($guards)) {
       //      return redirect('/login');
       //  }
        if(Auth::guard('admin')->check()){
             return $next($request);
        }

        if(Auth::guard('web')->check()){
            return redirect('/home');
        }



        
        return redirect('/login');
    }
}
