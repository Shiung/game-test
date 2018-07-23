<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\ShareTransactionRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class ShareTransactionService {
    
    protected $transactionRepository;
    protected $feature_name = '娛樂幣交易';

    /**
     * TransactionService constructor.
     * @param ShareTransactionRepository $transactionRepository
     */
    public function __construct(
        ShareTransactionRepository $transactionRepository
    ) {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     *  依照狀態取得所有資料
     * @param string $status
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByStatus($status,$start,$end)
    {
        return $this->transactionRepository->allByStatus($status,$start,formatEndDate($end));
    }
    
    /**
     *  特定會員取得掛單紀錄
     * @param int $member_id
     * @param string $status
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allBySellerId($member_id,$status,$start,$end)
    {
        return $this->transactionRepository->allBySellerId($member_id,$status,$start,formatEndDate($end));
    }

    /**
     *  特定會員購買成交紀錄
     * @param int $member_id
     * @param string $status
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByBuyerId($member_id,$status,$start,$end)
    {
        return $this->transactionRepository->allByBuyerId($member_id,$status,$start,formatEndDate($end));
    }

    /**
     * 依照排序回傳最便宜掛單
     * @param string $status
     * @param int $limit
     * @param int $member_id
     * @return collection 
     */
    public function getCheapestDatas($status,$limit,$member_id = null)
    {
        $datas =  $this->transactionRepository->getCheapestDatas($status,$limit,$member_id);
        $new_datas = $datas->map(function ($data) {
            $data['seller_username'] = $data->seller_user->username;
            return $data;
        });
        return $new_datas;
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
     * 成交
     * @param int $id
     * @return collection
     */
    public function dealTransaction($id)
    {
        DB::beginTransaction();
        try{
            $data['share_transaction_id'] = $id;
            $data['token'] = Session::get('m_token');
            $result = curlApi(env('API_URL').'/product/buy_share',$data); 
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

    /**
     * 取消掛單
     * @param int $id
     * @return collection
     */
    public function cancelTransaction($id)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('m_token');
            $data['share_transaction_id'] = $id;
            $result = curlApi(env('API_URL').'/product/cancel_share',$data); 
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
