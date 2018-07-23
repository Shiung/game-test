<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\System\AdminRepository;
use Auth;
use App\Models\Admin;
use App\Services\AuthService;
use App\Services\System\AdminActivityService;
use Validator;
use Redirect;
use App;
use Session;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * 參數設定
     *
     * @var string
     */
    protected $redirectTo = '/game-admin';
    protected $redirectAfterLogout = '/game-admin/auth/login';
    protected $loginView = 'admin.auth.login';
    protected $username = 'username';
    protected $guard = 'admin';
    protected $authService;
    protected $adminLog;

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct( AuthService $authService, AdminActivityService $adminLog ) {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout', 'getLogout']);  
        $this->authService = $authService;  
        $this->adminLog = $adminLog;
    }

    /**
     * 登入驗證成功的流程
     *
     * 如果前台會員登入，會自動導向前台
     * 正常登入會導向後台首頁
     * @param  Request $request
     * @param Admin $user
     * @return route
     */
    protected function authenticated(Request $request, Admin $user)
    {
        $this->adminLog->add([
            'admin_id' => $user->id, 
            'type' => '登入',
            'content' => $user->name.'登入後台'
        ]);
        return redirect()->route('admin.index');
    
    }


    /**
     * 登入驗證規則
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            'username.required'=> '請輸入帳號',
            'password.required'=> '請輸入密碼',
            'captcha.required'=> '請輸入驗證碼',
            
        ];
        //'captcha.captcha' => '驗證碼錯誤',
        $validator = Validator::make($request->all(), [

            'username' => 'required|max:255',
            'password' => 'required',
            
            
        ],$messages);
        //'captcha' => 'required|captcha',
        if ($validator->fails()) {
           $this->throwValidationException(
                $request, $validator
            );
        } 

    }

    /**
     * 登入失敗的回應
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $this->authService->loginFailedProcess($request->username);
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * 登出流程
     * 
     * @return route
     */
    public function logout()
    {
        Session::forget('a_token');
        Auth::guard('admin')->logout();
        return redirect()->route('admin.index');
    }

    /**
     * 登入頁面
     *
     * @return view admin/auth/login.blade.php
     */
    public function getLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.index'); 
        }
        return view('admin.auth.login');
        
    }
    

}
