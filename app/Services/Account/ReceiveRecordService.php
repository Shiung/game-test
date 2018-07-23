<?php
namespace App\Services\Account;

use App;
use App\Repositories\Account\ReceiveRecordRepository;
use App\Services\System\AdminActivityService;
use App\Services\API\BonusService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class ReceiveRecordService {
    
    protected $recordRepository;
    protected $bonusService;
    protected $adminLog;
    protected $feature_name = '簽到中心領取紀錄';

    /**
     * ReceiveRecordService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param ReceiveRecordRepository $recordRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        ReceiveRecordRepository $recordRepository,
        BonusService $bonusService
    ) {
        $this->adminLog = $adminLog;
        $this->recordRepository = $recordRepository;
        $this->bonusService = $bonusService;
    }

    /**
     * 依照領取狀態取得資料
     * @param string $status
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($status='%',$start,$end)
    {
        return $this->recordRepository->all($status,$start,formatEndDate($end));
    }
    
    /**
     *  依照會員取得的資料(for 前台)
     * @param int $member_id
     * @param string $status
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByMemberToPaginate($member_id,$status='%',$start,$end,$page)
    {
        return $this->recordRepository->allByMemberToPaginate($member_id,$status,$start,formatEndDate($end),$page);
    }


    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->recordRepository->find($id);
    }

    /**
     * 領取
     * @param int $id
     * @return array
     */
    public function receive($id)
    {
        DB::beginTransaction();
        try{
            $result = $this->bonusService->get_money_from_receive_center($id);
            if($result['result']==0){
                DB::rollBack();
                return ['status' => false, 'error_code'=> 'DB_ERROR','error_msg' => json_encode($result)];
            }
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
        
    }

  
}
