<?php
namespace App\Services\Member;

use App;
use App\Repositories\Member\TransferOwnershipRecordRepository;
use App\Repositories\MemberRepository;
use App\Repositories\UserRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;
use App\Services\Member\MobileSmsService;
use Log;

class TransferOwnershipRecordService {
    
    protected $recordRepository;
    protected $memberRepository;
    protected $userRepository;
    protected $adminLog;
    protected $smsService;
    /**
     * TransferOwnershipRecordService constructor.
     * @param TransferOwnershipRecordRepository $recordRepository
     * @param AdminActivityService $adminLog
     */
    public function __construct(
        TransferOwnershipRecordRepository $recordRepository,
        MemberRepository $memberRepository,
        UserRepository $userRepository,
        AdminActivityService $adminLog,
        MobileSmsService $smsService
    ) {
        $this->adminLog = $adminLog;
        $this->recordRepository = $recordRepository;
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
        $this->smsService = $smsService;
    }

    /**
     * 取得列表
     * 
     * @return collection
     */
    public function all($start,$end,$status = '%',$member_id= '%')
    {
        return $this->recordRepository->all($start,formatEndDate($end),$status,$member_id);
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
        $records = $this->all('1911-01-01',date('Y-m-d'),0,$data['member_id']);
        if(count($records) == 0){
            return $this->recordRepository->add($data);
        }
        
    }


    /**
     * 確認
     * @param int $id
     * @return array
     */
    public function confirm($id)
    {
        DB::beginTransaction();
        try{
            $record = $this->find($id);

            //更新會員資料
            $this->memberRepository->update($record->member_id,['phone' => null,
                'name' => $record->name,
                'confirm_status' => 0,
                'agree_status' => 0,
                'confirmed_at' => null,
                'reset_pwd_status' => 0,
                'reset_pwd_at' => null,
            ]);

            //更新帳號資料
            $this->userRepository->update($record->member_id,[
                'username' => $record->username,
                'password' => $record->password,
                'last_session_id'=>'00000'
            ]);

            //更新狀態
            $this->recordRepository->update($id,['status'=>1,'admin_id' => Auth::guard('admin')->user()->id]);

            //新增log
            $this->adminLog->add([ 'content' =>  '確認'.'：'.$id ,'type' => '過戶']); 
            
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
            $msg = env('COMPANY_NAME','娛樂家').'通知:您的帳號更名申請已被拒絕，若有相關疑問請聯繫線上客服中心謝謝';

            $this->smsService->send($record->user->member->phone,$msg);

            //新增log
            $this->adminLog->add([ 'content' =>  '拒絕'.'：'.$id ,'type' => '過戶']); 
            
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false,'error_code'=> 'EXCEPTION_ERROR' ,'error_msg'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    
  
}
