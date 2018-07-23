<?php

namespace App\Http\Controllers\Front;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ForgetPwdService;
use App\Services\AuthService;
use Auth;
use Redirect;
use App;
use Session;
use App\Models\User;
use Validator;
use App\Services\Content\PageService;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * 參數設定
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/auth/login';
    protected $loginView = 'front.auth.login';
    protected $username = 'username';
    protected $guard = 'web';
    protected $forgetPwdService;
    protected $authService;
    protected $pageService;


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        ForgetPwdService $forgetPwdService, 
        AuthService $authService,
        PageService $pageService
    ) {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout', 'getLogout']);  
        $this->forgetPwdService = $forgetPwdService; 
        $this->authService = $authService; 
        $this->pageService = $pageService;
    }

    /**
     * 登入request 處理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255',
            'password' => 'required',
            'captcha' => 'required',
        ]);

        if ($validator->fails()) {
           return json_encode(['result' => 0 ,'text' => '欄位未完整']);
        } 

        $validator = Validator::make($request->all(), [
            'captcha' => 'captcha',
        ]);

        if ($validator->fails()) {
           return json_encode(['result' => 0 ,'text' => '驗證碼錯誤，請重新輸入']);
        } 

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        if($request->remember == 1){
            $remember = true;
        } else {
            $remember = false;
        }
        if (Auth::guard($this->getGuard())->attempt($credentials, $remember)) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 登入驗證成功的流程
     *
     * 如果前台會員登入，會自動導向前台
     * 正常登入會導向後台首頁
     * @param  Request $request
     * @param User $user
     * @return json
     */
    protected function authenticated(Request $request, User $user)
    {
        if($user->member->show_status == 0){
            //登出
            Auth::guard( 'web' )->logout(); 
            return json_encode(['result' => 0 ,'text' => '帳號或密碼錯誤']);
        }
        //檢查會員登入權限
        if($user->login_permission == 0) {
            //登出
            Auth::guard( 'web' )->logout(); 
            return json_encode(['result' => 0 ,'text' => '您的帳號已被停權，請聯絡客服']);
        }

        if($user->type == 'admin'){
            return json_encode(['result' => 0 ,'text' => '帳號或密碼錯誤']);
        }
        
        //新增登入紀錄
        $this->authService->loginSuccessProcess($user);

        return json_encode(['result' => 1,'text' => '登入成功']);
    }

    /**
     * 登入失敗的回應
     *
     * @param Request  $request
     * @return json
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $this->authService->loginFailedProcess($request->username);
        return json_encode(['result' => 0 ,'text' => '帳號或密碼錯誤']);
    }

    /**
     * 登出流程
     * 
     * @return route
     */
    public function logout()
    {
        Auth::guard('web')->user()->update(['last_session_id'=>'0000000000000000000000000000000000000000']);
        Session::forget('m_token');
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route('front.index');
        
    }

    /**
     * 登入頁面
     *
     * @return view front/auth/login.blade.php
     */
    public function getLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('front.index'); 
        }
        return view('front.auth.login');
        
    }

    /**
     * 使用者規章
     *
     * @return view front/auth/agreement.blade.php
     */
    public function agreement()
    {
        $data = [
             'data' => $this->pageService->getPageByCode('user_guide'),
        ];
        return view('front.auth.agreement',$data);
        
    }


    
    /**
     * 忘記密碼
     *
     * @return view front/auth/forget_pwd.blade.php
     */
    public function forgetPwdIndex()
    {
        return view('front.auth.forget_pwd');
    }

    /**
     * 忘記密碼處理
     * @param Request $request
     * @return json
     */
    public function forgetPwdProcess(Request $request)
    {

        //檢查使用者是否存在
        if(!$this->forgetPwdService->checkUser($request->username,$request->phone)){
            return json_encode(['result' => 0 ,'text' => '找不到此會員']);
        }
     
        //重設密碼
        $result = $this->forgetPwdService->resetPassword();
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => '新密碼已寄到您的手機，登入後請務必重新設定密碼！'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }  
    }
    


}
