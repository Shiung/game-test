<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * 管理員權限登入檢查
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        //沒有管理員登入
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('admin.login.index');
        }

        return $next($request);
    
    }
}
