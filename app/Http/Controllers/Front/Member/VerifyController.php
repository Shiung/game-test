<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App;
use Session;
use App\Services\UserService;
use App\Services\Member\MobileSmsService;
use App\Services\Member\MemberService;
use App\Services\Content\PageService;
use Validator;

class VerifyController extends Controller
{

    /**
     * 參數設定
     *
     * @var string
     */
    protected $userService;
    protected $smsService;
    protected $memberService;
    protected $pageService;
    protected $user;

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        UserService $userService, 
        MemberService $memberService, 
        PageService $pageService, 
        MobileSmsService $smsService
    ) {
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->smsService = $smsService;
        $this->pageService = $pageService;
        $this->user = Auth::guard('web')->user();

    }

    /**
     * 輸入簡訊驗證碼頁面
     *
     * @return view front/verify/sms.blade.php
     */
    public function smsIndex(Request $request)
    {

        if($this->user->member->confirm_status == 1){
            //已經驗證過
            return redirect()->route('front.index');
        }

        //檢查參數
        $v = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($v->fails()){
            abort(404);
        }

        $data=[
            'phone' => $request->phone,
            'page_title' => '簡訊認證'
        ];
        return view('front.verify.sms',$data);
        
    }

    /**
     * 產生簡訊驗證碼
     * @param Request $request
     * @return json
     */
    public function createSmsVerify(Request $request)
    {
        //呼叫產生簡訊認證
        if($request->phone == 'default'){
            $result = $this->smsService->createVerify($this->user,$this->user->member->phone);
        } else {
            Session::put('phone', $request->phone);
            $result = $this->smsService->createVerify($this->user,$request->phone);
        }

        if($result['status']){
            return json_encode(array('result' => 1,'id' => $result['id']));
        } else {
            return json_encode(array('result' => 0,'error' => $result['error'], 'text' => $result['error_msg']));
        }
        
    }

    /**
     * 第一次簡訊驗證
     * @param Request $request
     * @return json
     */
    public function smsAuth(Request $request)
    {
       //檢查參數
        $v = Validator::make($request->all(), [
            'code' => 'required',
            'id' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
        }

        //呼叫產生簡訊認證
        $result = $this->smsService->verify($request->id,$request->code);
        if($result['status']){
            //更新狀態
            $this->user->member->update([
                'phone' => Session::get('phone'),
                'confirm_status' => 1,
                'confirmed_at' => date('Y-m-d H:i:s')
            ]);
            Session::forget('phone');
            return json_encode(array('result' => 1,'id' => $result['id']));
        } else {

            return json_encode(array('result' => 0,'error' => $result['error'], 'text' => $result['error_msg'],'id' => $result['id']));
        }

    }

    /**
     * 輸入手機頁面
     *
     * @return view front/verify/phone.blade.php
     */
    public function phoneIndex()
    {
        if($this->user->member->confirm_status == 1){
            //已經驗證過
            return redirect()->route('front.index');
        } 
        return view('front.verify.phone',['page_title' => '第一次手機認證']);  
    }

    /**
     * 檢查手機是否重複
     * @param Request $request
     * @return json
     */
    public function phoneCheck(Request $request)
    {
        //檢查手機是否存在
        if($this->memberService->checkIfPhoneCanUse($request->phone,$this->user->id)){    
            return json_encode(array('result' => 1));
        } else {
            return json_encode(array('result' => 0,'text' => '手機號碼已存在，請勿重複使用'));
        }
    }

    /**
     * 重設密碼頁面
     *
     * @return view front/verify/first_reset_password.blade.php
     */
    public function firstResetPwdIndex()
    {
       if($this->user->member->reset_pwd_status == 1){
            //已經重設過
            return redirect()->route('front.index');
       }
       return view('front.verify.first_reset_password',['page_title' => '重設密碼']);  
    }

    /**
     * 重設密碼處理
     * @param Request $request
     * @return json
     */
    public function resetPwdProcess(Request $request)
    {
        //檢查參數是否存在
        $v = Validator::make($request->all(), [
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0, 'text' => '請重新確認密碼'));
        }
        
        //檢查密碼是否存在不合法符號
        $v = Validator::make($request->all(), [
            'password' => 'min:5|without_spaces|password_valid_str',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0, 'text' => '密碼格式不正確'));
        }
        
        //檢查密碼是否一致
        if($request->password != $request->password_confirmation) {
            return json_encode(array('result' => 0, 'text' => '請重新確認密碼'));
        }

        $result = $this->userService->updatePassword('member',$this->user,$request->password);
        if ($result['status'] ) {
            return json_encode(array('result' => 1, 'text' => '重設密碼成功，請重新登入'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 
    }


    /**
     * 使用者規範同意頁面
     *
     * @return view front/verify/agreement.blade.php
     */
    public function agreementIndex()
    {
       if($this->user->member->agree_status == 1){
            //已經重設過
            return redirect()->route('front.index');
       }
       $data = [
            'data' => $this->pageService->getPageByCode('user_guide'),
            'page_title' => '使用者規範'
       ];
       return view('front.verify.agreement',$data );  
    }

    /**
     * 同意使用者規範處理
     * @param Request $request
     * @return json
     */
    public function agreementProcess(Request $request)
    {
        //檢查參數是否存在
        $v = Validator::make($request->all(), [
            'agreement' => 'required|in:1',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0, 'text' => '請勾選同意'));
        }
        $result = $this->memberService->update('member',$this->user->id,['agree_status' => 1]);
        if ($result['status'] ) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 
    }



}
