<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App;
use Session;
use App\Services\UserService;
use App\Services\Member\MemberService;
use App\Services\Member\MobileSmsService;
use Validator;

class UserController extends Controller
{

    /**
     * 參數設定
     *
     * @var string
     */
    protected $userService;
    protected $memberService;
    protected $smsService;
    protected $user;

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        MemberService $memberService,
        MobileSmsService $smsService
    ) {
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->smsService = $smsService;
        $this->user = Auth::guard('web')->user();

    }

    /**
     * 個人資料瀏覽頁面
     *
     * @return view front/member/info.blade.php
     */
    public function info()
    {
        //會員等級資訊
        $member_level_info = $this->memberService->searchMemberLevel($this->user->id,$this->user->type);

        $data = [
            'page_title' => '個人資料瀏覽',
            'level_expire' => $member_level_info['level_expire'],
            'level' => $member_level_info['level_name'],
            'data' => $this->user->member
        ];
        return view('front.member.info',$data);  
    }

    /**
     * 直接推薦下線列表頁面
     *
     * @return view front/member/subs.blade.php
     */
    public function subs()
    {
        $data = [
            'page_title' => '好友列表',
            'datas' => $this->memberService->getSubMembers($this->user->id)
        ];
        return view('front.member.subs',$data);  
    }

    /**
     * 直接推薦下線資訊
     * @param int $id 下線會員id
     * @return view front/member/sub_info.blade.php
     */
    public function subInfo($id)
    {
        $member = $this->memberService->find($id);
        if(!$member){
            abort(404);
        }
        //是否為自己的下線
        if($member->recommender_id != $this->user->id){
            abort(404);
        }
        $data = [
            'data' => $this->memberService->find($id)
        ];
        return view('front.member.sub_info',$data);  
    }


     /**
     * =======================
     * 個人資料編輯
     * =======================
     */

    /**
     * 個人資料編輯頁面
     *
     * @return view front/member/edit_info/edit.blade.php
     */
    public function editInfo()
    {
        $data = [
            'page_title' => '個人資料編輯',
            'data' => $this->user->member
        ];
        return view('front.member.edit_info.edit',$data);  
    }

    /**
     * 個人資料編輯簡訊驗證頁
     * @param Request $request
     * @return view front/member/edit_info/sms.blade.php
     */
    public function infoSmsIndex(Request $request)
    {
        //檢查參數
        $v = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
        }

        ($request->has('bank_code'))?($bank_code = $request->bank_code):($bank_code = '');
        ($request->has('bank_account'))?($bank_account = $request->bank_account):($bank_account = '');
        $data = [
            'page_title' => '個人資料編輯-簡訊驗證',
            'name' => $request->name,
            'bank_code' => $bank_code,
            'bank_account' => $bank_account
        ];
        return view('front.member.edit_info.sms',$data);  
    }

    /**
     * 更新個人資料
     * @param Request $request
     * @return json
     */
    public function updateInfo(Request $request)
    {
        //檢查參數
        $v = Validator::make($request->all(), [
            'code' => 'required',
            'id' => 'required',
            'name' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
        }

        //呼叫產生簡訊認證
        $result = $this->smsService->verify($request->id,$request->code);
        if($result['status']){
            $update_data = [
                'name' => $request->name,
                'bank_code' => $request->bank_code,
                'bank_account' => $request->bank_account,
            ];
            //更新資料
            $update_result = $this->memberService->update('member',$this->user->id,$update_data);
            if ($update_result['status'] ) {
                return json_encode(array('result' => 1, 'text' => 'Success','id' => $result['id']));
            } else {
                return json_encode(array('result' => 0, 'text' => $update_result['error']));
            } 
        } else {

            return json_encode(array('result' => 0,'error' => $result['error'], 'text' => $result['error_msg'],'id' => $result['id']));
        }

    }

    /**
     * =======================
     * 重設密碼
     * =======================
     */

    /**
     * 重設密碼頁面
     *
     * @return view front/member/reset_pwd/edit.blade.php
     */
    public function editPwd()
    {
        $data = [
            'page_title' => '重設密碼',
        ];
        return view('front.member.reset_pwd.edit',$data);  
    }

    /**
     * 個人資料編輯簡訊驗證頁
     * @param Request $request
     * @return view front/member/reset_pwd/sms.blade.php
     */
    public function pwdSmsIndex(Request $request)
    {
        //檢查參數
        $v = Validator::make($request->all(), [
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
        }
        $data = [
            'page_title' => '個人資料編輯-簡訊驗證',
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation

        ];
        return view('front.member.reset_pwd.sms',$data);  
    }

    /**
     * 重設密碼處理（包含簡訊認證）
     * @param Request $request
     * @return json
     */
    public function resetPwdProcess(Request $request)
    {
        //檢查參數是否存在
        $v = Validator::make($request->all(), [
            'code' => 'required',
            'id' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
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

        //呼叫產生簡訊認證
        $result = $this->smsService->verify($request->id,$request->code);
        if($result['status']){
            //重設密碼
            $update_result = $this->userService->updatePassword('member',$this->user,$request->password);
            if ($update_result['status'] ) {
                return json_encode(array('result' => 1, 'text' => 'Success','id' => $result['id']));
            } else {
                return json_encode(array('result' => 0, 'text' => $update_result['error']));
            } 
        } else {
            return json_encode(array('result' => 0,'error' => $result['error'], 'text' => $result['error_msg'],'id' => $result['id']));
        }
 
    }

    /**
     * 檢查帳號是否存在
     * @param Request $request
     * @return json
     */
    public function checkUsernameExist(Request $request)
    {
        //檢查帳號是否可用
        $member = $this->userService->getUserByUsername($request->username);
        if($member){
            return json_encode(array('result' => 1));
        }
        return json_encode(array('result' => 0));
    }





}
