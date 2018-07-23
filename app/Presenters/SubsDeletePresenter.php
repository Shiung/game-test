<?php
namespace App\Presenters;

use App\Services\Member\MemberService;
use App\Services\Member\SubsDeleteRecordService;
use Auth;

class SubsDeletePresenter
{

    protected $memberService;
    protected $recordService;
    protected $user;

    /**
     * BetPresenter constructor.
     *
     * @param 
     */
    public function __construct(
        SubsDeleteRecordService $recordService,
        MemberService $memberService
    ) {
        $this->recordService = $recordService;
        $this->memberService = $memberService;
        $this->user = Auth::guard('web')->user();
    }


    /**
     * 判斷會員是否開放刪除
     * @param $member
     * @return bool
     */
    public function checkIfMemberCanBeDeleted($member)
    {

       $user = $member->user;
       //檢查餘額
       if(!$this->recordService->checkAccount($member)){
          return false;
        }

        //檢查是否有下線
        if(!$this->recordService->checkTree($member)){
          return false;
        }

        //檢查推薦人是否為登入人
        if($member->recommender_id != $this->user->id){
          return false;
        }

        //檢查最後登入時間
        if(!$this->recordService->checkLastActivity($user)){
          return false;
        }

        //檢查是否已經申請過
        $record = $this->recordService->all('1911-01-01',date('Y-m-d'),'0',$this->user->id,$user->id);
        if(count($record)>0){
          return false;
        }

        $record = $this->recordService->all('1911-01-01',date('Y-m-d'),'1',$this->user->id,$user->id);
        if(count($record)>0){
          return false;
        }

        return true;

       
    }


   
}