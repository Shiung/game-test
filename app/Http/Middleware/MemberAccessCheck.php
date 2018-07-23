<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class MemberAccessCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        //不是會員身份
        if(Auth::guard($guard)->user()->type != 'members') {
            return redirect()->route('front.survey.index');
        }
            
        return $next($request);

        
    }
}
