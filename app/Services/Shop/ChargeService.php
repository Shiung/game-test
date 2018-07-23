<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\ChargeRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class ChargeService {
    
    protected $chargeRepository;
    protected $adminLog;
    protected $feature_name = '金幣儲值';

    /**
     * ChargeService constructor.
     * @param AdminActivityService $adminLog
     * @param ChargeRepository $chargeRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        ChargeRepository $chargeRepository
    ) {
        $this->adminLog = $adminLog;
        $this->chargeRepository = $chargeRepository;
    }

    /**
     *  依照類型取得所有訊息資料
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($start,$end)
    {
        return $this->chargeRepository->all($start,formatEndDate($end));
    }
    
    /**
     *  依照會員取得的資料(for 前台)
     * @param int $member_id
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByMember($member_id,$start,$end)
    {
        return $this->chargeRepository->allByMember($member_id,$start,formatEndDate($end));
    }


    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->chargeRepository->find($id);
    }

    /**
     * 更新
     * @param int $id, 
     * @param array $data
     * @return array
     */
    public function update($id,$data)
    {
        DB::beginTransaction();
        try{
            $this->chargeRepository->update($id,$data);  
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 確認發送現金碼
     * @param int $id
     * @param int $status
     * @return array
     */
    public function confirm($id,$status)
    {
        if($status == '1'){
            DB::beginTransaction();
            try{
                $result = curlApi(env('API_URL')."/account/give_virtual_cash",array( "charge_id" => $id,"token" => Session::get('a_token'))); 
            } catch (Exception $e){
             DB::rollBack();
             return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
            }
            DB::commit();
            $result = json_decode($result, true);
            if($result['result'] == 1){
                return ['status' => true];
            } else {
                return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
            }
        } else {
            DB::beginTransaction();
            try{
                $this->update($id,[
                    'confirm_status' => 2,
                    'confirm_at' => date('Y-m-d H:i:s')
                ]);
                //新增log
                $this->adminLog->add([ 'content' =>  '拒絕購買 charge_id：'.$id ,'type' => $this->feature_name]); 
            } catch (Exception $e){
             DB::rollBack();
                return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
            }
            DB::commit();
            return ['status' => true];
        }
        
        
    }

    /**
     * 新增訊息
     * @param array $data
     * @return array
     */
    public function add($data)
    {   
        DB::beginTransaction();
        try{
            $id = $this->chargeRepository->add($data);  
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
        
    }
    
    /**
     * 刪除
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try{
            $this->chargeRepository->delete($id);  
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }


  
}
