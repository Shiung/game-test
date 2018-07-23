<?php
namespace App\Services\Member;

use App;
use App\Repositories\Member\SubsDeleteRecordRepository;
use App\Repositories\MemberRepository;
use App\Repositories\UserRepository;
use App\Services\System\AdminActivityService;
use App\Services\System\ParameterService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;
use App\Models\Tree;
use App\Services\Member\SmsService;


class SubsDeleteRecordService {
    
    protected $recordRepository;
    protected $memberRepository;
    protected $userRepository;
    protected $parameterService;
    protected $smsService;
    protected $adminLog;
    /**
     * SubsDeleteRecordService constructor.
     * @param TransferOwnershipRecordRepository $recordRepository
     * @param AdminActivityService $adminLog
     */
    public function __construct(
        SubsDeleteRecordRepository $recordRepository,
        MemberRepository $memberRepository,
        UserRepository $userRepository,
        AdminActivityService $adminLog,
        ParameterService $parameterService,
        SmsService $smsService
    ) {
        $this->adminLog = $adminLog;
        $this->recordRepository = $recordRepository;
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
        $this->parameterService = $parameterService;
        $this->smsService = $smsService;

    }

    /**
     * 取得列表
     * 
     * @return collection
     */
    public function all($start,$end,$status = '%',$member_id= '%',$delete_member_id = '%')
    {
        return $this->recordRepository->all($start,formatEndDate($end),$status,$member_id,$delete_member_id);
    }

    /**
     * 取得單一
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->recordRepository->find($id);
    }

    /**
     * 新增
     * @param array $data
     * @return collection
     */
    public function add($data)
    {
        //檢查是否有已經申請過的
        $records = $this->all('1911-01-01',date('Y-m-d'),0,'%',$data['delete_member_id']);
        if(count($records) == 0){
            //更新帳號資料
            $this->userRepository->update($data['delete_member_id'],[
                'login_permission' => 0,
                'last_session_id'=>'00000'
            ]);
            return $this->recordRepository->add($data);
        }
        
    }


    /**
     * 確認
     * @param string $type
     * @param int $id
     * @return array
     */
    public function confirm($id)
    {
        DB::beginTransaction();
        try{
            $record = $this->find($id);

            //更新會員資料
            $this->memberRepository->update($record->delete_member_id,[
                'show_status' => 0,
                'phone' => null
            ]);

            $delete_user = $record->delete_user;
            //更新帳號資料
            $this->userRepository->update($record->delete_member_id,[
                'login_permission' => 0,
                'last_session_id'=>'00000',
                'username' => $delete_user->username.'-del'.date('YmdHis'),
            ]);

            //更新狀態
            $this->recordRepository->update($id,['status'=>1,'admin_id' => Auth::guard('admin')->user()->id]);

            //刪除樹結構
            Tree::where('member_id',$record->delete_member_id)->delete();

            //新增log
            $this->adminLog->add([ 'content' =>  '確認'.'：#'.$id ,'type' => '會員刪除']); 
            
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 拒絕
     * @param int $id
     * @return array
     */
    public function reject($id)
    {
        DB::beginTransaction();
        try{
            $record = $this->find($id);

            //更新狀態
            $this->recordRepository->update($id,['status'=>2,'admin_id' => Auth::guard('admin')->user()->id]);
                        //寄簡訊通知
            $msg = env('COMPANY_NAME','娛樂家').'通知:您的好友帳戶刪除申請已被拒絕，若有相關疑問請聯繫線上客服中心謝謝';

            $this->smsService->send($record->user->member->phone,$msg);

            //新增log
            $this->adminLog->add([ 'content' =>  '拒絕'.'：'.$id ,'type' => '會員刪除']); 
            
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }



    /**
     * 檢查帳戶餘額
     *
     * @param  $member
     * @return bool
     */
    public function checkAccount($member)
    {
        $accounts = $member->accounts;
        $params = $this->getParams();

        if($accounts->where('type','1')->first()->amount > $params['cash_min'] ){
            return false;
        }

        if($accounts->where('type','3')->first()->amount > $params['share_min'] ){
            return false;
        }

        if($accounts->where('type','2')->first()->amount > $params['manage_min'] ){
            return false;
        }

        return true;

    }

    /**
     * 檢查最後登入時間
     *
     * @param  $user
     * @return bool
     */
    public function checkLastActivity($user)
    {

        if(!$user->last_activity_at){
            return true;
        }
        $days = $this->parameterService->find('sub_delete_last_login_days');
        if($days > 0){
            $startdate = strtotime(date('Y-m-d'));
            $enddate = strtotime("-".$days." days",$startdate);

            if(strtotime($user->last_activity_at) > $enddate){
              return false;
            }
        }
        
        return true;
    }

    /**
     * 檢查是否有下線
     *
     * @param  $user
     * @return bool
     */
    public function checkTree($member)
    {
      if(count($member->tree_subs) > 0 ){
        return false;
      }
      return true;
    }

    /**
     * 取得刪除參數
     * @return array
     */
    public function getParams()
    {
       return [
          'cash_min' => $this->parameterService->find('sub_delete_cash_min'),
          'share_min' => $this->parameterService->find('sub_delete_share_min'),
          'manage_min' => $this->parameterService->find('sub_delete_manage_min'),
          'days_min' => $this->parameterService->find('sub_delete_last_login_days'),
       ];
    }


    
  
}
