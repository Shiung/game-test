<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Services\TokenService;

class Authenticate
{


    /**
     * 一般會員登入檢查
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        //沒有登入
        if (!Auth::guard($guard)->check()) {
            Session::flush();
            return redirect()->guest('auth/login');
        }
        
        //登入權限被關閉
        if(Auth::guard('web')->user()->login_permission == 0) {
            //登出
            Session::flush();
            Auth::guard( 'web' )->logout(); 
            return redirect()->guest('auth/login');
        } 
        //檢查session是否一致
        if(Auth::guard('web')->user()->last_session_id != session()->getId()){
            Auth::guard('web')->user()->update(['last_session_id'=>'0000000000000000000000000000000000000000']);
            //登出
            Auth::guard( 'web' )->logout(); 
            Session::flush();
            return redirect()->guest('auth/login');
        }

        //更新最後活動時間
        Auth::guard('web')->user()->update([
            'last_activity_at' => date('Y-m-d H:i:s')
        ]);
        return $next($request);

        
    }
}
