<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class FirstVerify
{
    /**
     * 第一次登入相關驗證
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {

        //尚未按下同意
        $member = Auth::guard('web')->user()->member;
        if($member->agree_status == 0) {
            return redirect()->route('front.verify.agreement.index');
        } 

        //尚未簡訊驗證
        if($member->confirm_status == 0) {
            return redirect()->route('front.verify.phone');
        } 

        //尚未修改密碼
        if($member->reset_pwd_status == 0) {
            return redirect()->route('front.verify.first_reset_pwd.index');
        }

        
        return $next($request);

        
    }
}
