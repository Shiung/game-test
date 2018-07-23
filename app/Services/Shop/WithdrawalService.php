<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\WithdrawalRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class WithdrawalService {
    
    protected $withdrawalRepository;
    protected $adminLog;
    protected $feature_name = '紅包群發';
    /**
     * WithdrawalService constructor.
      * @param AdminActivityService $adminLog
     * @param AdminActivityService $adminLog,WithdrawalRepository $withdrawalRepository
     */
    public function __construct(
        AdminActivityService $adminLog, 
        WithdrawalRepository $withdrawalRepository
    ) {
        $this->adminLog = $adminLog;
        $this->withdrawalRepository = $withdrawalRepository;
    }

    /**
     *  依照類型取得所有訊息資料
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($start,$end)
    {
        return $this->withdrawalRepository->all($start,formatEndDate($end));
    }
    
    /**
     *  依照會員取得(for 前台)
     * @param int $member_id
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByMember($member_id,$start,$end)
    {
        return $this->withdrawalRepository->allByMember($member_id,$start,formatEndDate($end));
    }


    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->withdrawalRepository->find($id);
    }

    /**
     * 更新出金狀態
     * @param int $id
     * @param int $status
     * @return collection
     */
    public function updateStatus($id,$status)
    {

        try{
            $data['withdraw_id'] = $id;
            $data['status'] = $status;
            $data['token'] = Session::get('a_token');
            $result = curlApi(env('API_URL').'/account/withdraw_confirm',$data); 
        } catch (Exception $e){

         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }

        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }
    
  
}
