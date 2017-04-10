<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class StudentMiddleware
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
        $user_id=$request->id;

        if($user_id!=Auth::user()->student_id){
            return redirect('home');
        }

        return $next($request);
    }
}
