<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\TransactionRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class TransactionService {
    
    protected $transactionRepository;
    protected $adminLog;
    protected $feature_name = '商品紀錄';

    /**
     * TransactionService constructor.
     * @param AdminActivityService $adminLog
     * @param ChargeRepository $chargeRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        TransactionRepository $transactionRepository
    ) {
        $this->adminLog = $adminLog;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     *  依照類型取得所有資料
     * @param string $type
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($type,$start,$end)
    {
        return $this->transactionRepository->all($type,$start,formatEndDate($end));
    }

    /**
     *  依照類型、商品類別取得所有資料
     * @param string $type
     * @param int $category_id
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByCategoryId($type,$category_id,$start,$end)
    {
        return $this->transactionRepository->allByCategoryId($type,$category_id,$start,formatEndDate($end));
    }
    
    /**
     *  依照會員取得的獲得商品資料(for 前台)
     * @param int $member_id
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByReceiveMember($member_id,$start,$end)
    {
        return $this->transactionRepository->allByReceiveMember($member_id,$start,formatEndDate($end));
    }

    /**
     *  依照會員取得的轉移商品資料(for 前台)
     * @param int $member_id
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByTransferMember($member_id,$start,$end)
    {
        return $this->transactionRepository->allByTransferMember($member_id,$start,formatEndDate($end));
    }


    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->transactionRepository->find($id);
    }

    /**
     * 公司贈送商品
     * @param array $data
     * @return collection
     */
    public function giveProduct($data)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('a_token');
            $result = curlApi(env('API_URL').'/product/send',$data); 
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
    }

   
  
}
