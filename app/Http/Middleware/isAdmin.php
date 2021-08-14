<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class isAdmin
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
        if($request->path() == 'app/admin_login'){
            return $next($request);
        }
        if(!Auth::check()){
            return response()->json(["msg","you have not allowed to login"],403);
        }
        if(Auth::user()->userType == "User"){
            return response()->json(["msg","you have not allowed to login"],403);
        }
        return $next($request);
    }
}
