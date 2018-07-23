<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Member\MemberService;
use App\Services\Member\TransferOwnershipRecordService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Validator;

class MembersController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $memberService;
    protected $userService;
    protected $transferOwnershipRecordService;
    protected $page_title = '會員管理';
    protected $menu_title = '會員管理';
    protected $route_code = 'member';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        MemberService $memberService,
        TransferOwnershipRecordService $transferOwnershipRecordService,
        UserService $userService
    ){
        $this->memberService = $memberService;
        $this->userService = $userService;
        $this->transferOwnershipRecordService = $transferOwnershipRecordService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     * 
     * @return view front/member/index.blade.php
     */
    public function index()
    {

    	$datas = $this->memberService->all(); 
        $data =[
            'datas' => $datas,
        ];

        return view('admin.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    /**
     * 瀏覽頁面
     *
     * @param  int $id
     * @return view front/member/show.blade.php
     */
    public function show($id)
    {
        $member = $this->memberService->find($id); 
        if(!$member){
            abort(404);
        }
        //會員等級資訊
        $member_level_info = $this->memberService->searchMemberLevel($id,$member->user->type);
        $data =[
            'data' => $member,
            'level_expire' => $member_level_info['level_expire'],
            'level' => $member_level_info['level_name'],
            'transfer_ownership_records' => $this->transferOwnershipRecordService->all('1911-01-01',date('Y-m-d'),1,$id)
        ];
        return view('admin.'.$this->route_code.'.show',array_merge($this->view_data,$data));
    }

    
    /**
     * 編輯頁面
     *
     * @param  int $id
     * @return view front/member/edit.blade.php
     */
    public function edit($id)
    {
        $member = $this->memberService->find($id); 
        if(!$member){
            abort(404);
        }
        $data =[
            'data' => $member,
        ];
        return view('admin.'.$this->route_code.'.edit',array_merge($this->view_data,$data));
    }

    /**
     * 好友列表頁面
     *
     * @param  int $id
     * @return view front/member/subs.blade.php
     */
    public function subIndex($id)
    {
        $member = $this->memberService->find($id); 
        if(!$member){
            abort(404);
        }
        $subs = $this->memberService->getSubMembers($id);

        $data =[
            'data' => $member,
            'datas' => $subs,
        ];

        return view('admin.'.$this->route_code.'.subs',array_merge($this->view_data,$data));
    }


    /**
     * 重設密碼頁面
     *
     * @param  int $id
     * @return view front/member/reset_pwd.blade.php
     */
    public function resetPwd($id)
    {
        $info = $this->memberService->find($id); 
        $data =[
            'data' => $info,
        ];
        return view('admin.'.$this->route_code.'.reset_pwd',array_merge($this->view_data,$data));
    }

    /**
     * 資料更新處理
     *
     * @param  int $id
     * @param Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $data = [
            'phone' => $request->phone, 
        ];
        $result = $this->memberService->update('admin',$id,$data,'手機號碼') ;
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }

    /**
     * 登入狀態更改
     *
     * @param  int $id
     * @param Request $request
     * @return json
     */
    public function updateLoginPermission($id,Request $request)
    {   
        $data = [
            'login_permission' => $request->login_permission, 
            'pwd_wrong_count' => 0
        ];

        $result = $this->userService->update('admin',$id,$data,'帳號登入權限');
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }

    /**
     * 密碼更新處理
     *
     * @param  $id
     * @param Request $request
     * @return json
     */
    public function updatePassword($id,Request $request)
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

        $user = $this->userService->find($id);

        $result = $this->userService->updatePassword('admin',$user,$request->password);
        if ($result['status'] ) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }

    }
    
    


}
