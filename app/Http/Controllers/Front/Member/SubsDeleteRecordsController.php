<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Member\SubsDeleteRecordService;
use App\Services\Member\MemberService;

use App\Services\UserService;
use App;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class SubsDeleteRecordsController extends Controller
{

    protected $recordService;
    protected $memberService;
    protected $userService;
    protected $user;
    protected $page_title = '好友帳戶刪除申請';
    protected $route_code = 'subs_delete_record';
    
	public function __construct(
        SubsDeleteRecordService $recordService,
        UserService $userService,
        MemberService $memberService
    ) {
        $this->recordService = $recordService;
        $this->memberService = $memberService;
        $this->userService = $userService;
        
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 列表
     * @param date $start
     * @param date $end
     * @return view front/shop/subs_delete_record/index.blade.php
     */
    public function index()
    {
    	$data=[
            'datas' => $this->recordService->all('1911-01-01',date('Y-m-d'),'0',$this->user->id,'%'),
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.member.'.$this->route_code.'.index',$data);
    }

    /**
     * 申請頁面
     * @param date $start
     * @param date $end
     * @return view front/shopsubs_delete_record/create.blade.php
     */
    public function create()
    {
      $data=[
            'subs' => $this->memberService->getSubMembers($this->user->id),
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'params'=> $this->recordService->getParams(), 
      ];

      return view('front.member.'.$this->route_code.'.create',$data);
    }

    /**
     * 取得下線資本資訊
     * @param Request $request
     * @return json
     */
    public function getSubInfoData(Request $request)
    {
        $member = $this->memberService->find($request->member_id);
        $user = $member->user;
        if(!$user->last_activity_at){
          $last_activity_at = '無';
        } else {
          $last_activity_at = $user->last_activity_at;
        }

        $accounts = $member->accounts;

        return json_encode([
          'result' => 1, 
          'last_activity_at' => $last_activity_at,
          'cash' =>  number_format($accounts->where('type','1')->first()->amount),
          'share' => number_format($accounts->where('type','3')->first()->amount),
          'manage' => number_format($accounts->where('type','2')->first()->amount),
        ]);


    }


    /**
     * 資料儲存處理
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
                'delete_member_id' => 'required',
            ]);

            if ($v->fails()){
                return json_encode(array('result' => 0,'error' => 'REQUEST_ERROR', 'text' => '參數不正確','content' => $v->messages()));
            }

            $delete_member = $this->memberService->find($request->delete_member_id);
            if(!$delete_member){
              return json_encode(array('result' => 0,'error' => 'MEMBER_NOT_FOUND', 'text' => '會員不存在'));
            }

            $delete_user = $delete_member->user;
            //檢查餘額
            if(!$this->recordService->checkAccount($delete_member)){
              return json_encode(array('result' => 0,'error' => 'ACCOUNT_ERROR', 'text' => '帳戶餘額不符合刪除條件'));
            }

            //檢查最後登入時間
            if(!$this->recordService->checkLastActivity($delete_user)){
              return json_encode(array('result' => 0,'error' => 'ACCOUNT_ERROR', 'text' => '最後活動時間不符合刪除條件'));
            }

            //檢查是否有下線
            if(!$this->recordService->checkTree($delete_member)){
              return json_encode(array('result' => 0,'error' => 'TREE_ERROR', 'text' => '該好友尚有下線'));
            }

            //檢查推薦人是否為登入人
            if($delete_member->recommender_id != $this->user->id){
              return json_encode(array('result' => 0,'error' => 'RECOMMENDER_ERROR', 'text' => '只有推薦人可申請刪除'));
            }

            //檢查是否已經申請過
            $confirm_record = $this->recordService->all('1911-01-01',date('Y-m-d'),'1',$this->user->id,$request->delete_member_id);
            $processing_record = $this->recordService->all('1911-01-01',date('Y-m-d'),'0',$this->user->id,$request->delete_member_id);
            
            if(count($confirm_record)>0 || count($processing_record)>0 ){
              return json_encode(array('result' => 0,'error' => 'REPEAT_ERROR', 'text' => '請勿重複申請刪除同一個好友'));
            }

            $data= [
               'member_id' => $this->user->id, 
               'delete_member_id' => $request->delete_member_id,
            ];
            $this->recordService->add($data);

        } catch (Exception $e){
          DB::rollBack();
          return json_encode(array('result' => 0, 'error' => $e->getMessage(),'text' => '系統發生錯誤，請聯繫客服人員'));
        }
        DB::commit();
        return json_encode(array('result' => 1, 'text' => 'Success'));

    }


   
}
