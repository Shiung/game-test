<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Member\TransferOwnershipRecordService;
use App\Services\Member\MobileSmsService;
use App\Services\UserService;
use App;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class TransferOwnershipRecordsController extends Controller
{

    protected $recordService;
    protected $smsService;
    protected $userService;
    protected $user;
    protected $page_title = '會員帳號更名申請';
    protected $route_code = 'transfer_ownership_record';
    
	public function __construct(
        TransferOwnershipRecordService $recordService,
        UserService $userService,
        MobileSmsService $smsService
    ) {
        $this->recordService = $recordService;
        $this->smsService = $smsService;
        $this->userService = $userService;
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 列表
     * @param date $start
     * @param date $end
     * @return view front/shop/transfer_ownership_record/index.blade.php
     */
    public function index()
    {
    	$data=[
            'datas' => $this->recordService->all('1911-01-01',date('Y-m-d'),'%',$this->user->id),
            'process_count' => count($this->recordService->all('1911-01-01',date('Y-m-d'),0,$this->user->id) ),
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.member.'.$this->route_code.'.index',$data);
    }

    /**
     * 輸入簡訊驗證碼頁面
     * @param Request $request
     * @return view front/member/transfer_ownership_record/sms.blade.php
     */
    public function smsIndex(Request $request)
    {
        $sms_state = 1;
        $error = '';
        $message = '';
        //檢查參數
        $v = Validator::make($request->all(), [
            'username' => 'required',
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($v->fails()){
            return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
        }


        $username = $this->userService->getUserByUsername($request->username);
        if($username){
            $sms_state = 0;
            $error = '帳號重複，請重新輸入';
        }
        $message = '帳號更名申請成功！';

        $data=[
            'sms_state' => $sms_state,
            'error' => $error,
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password,
            'message' => $message,
            'page_title' => '帳號更名申請-簡訊驗證',
        ];
        return view('front.member.'.$this->route_code.'.sms',$data);
        
    }


    /**
     * 簡訊認證+資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function process(Request $request)
    {
        DB::beginTransaction();
        try{
            //檢查參數
            $v = Validator::make($request->all(), [
                'code' => 'required',
                'id' => 'required',
                'username' => 'required',
                'name' => 'required',
                'password' => 'required',
            ]);

            if ($v->fails()){
                return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
            }

            //呼叫產生簡訊認證
            $result = $this->smsService->verify($request->id,$request->code);
            if($result['status']){
                $data= [
                   'member_id' => $this->user->id, 
                   'old_username' => $this->user->username,
                   'old_name' => $this->user->member->name,
                   'username' => $request->username,
                   'name' => $request->name,
                   'password' => bcrypt($request->password),
                ];
                $this->recordService->add($data);
  
            } else {
                return json_encode(array('result' => 0,'error' => $result['error_msg'], 'text' => $result['error_msg'],'id' => $result['id']));
            }

        } catch (Exception $e){
          DB::rollBack();
          return json_encode(array('result' => 0, 'error' => $e->getMessage(),'id' => $request->id));
        }
        DB::commit();
        return json_encode(array('result' => 1, 'text' => 'Success'));

    }


   
}
