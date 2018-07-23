<?php
namespace App\Services\Shop\Product;

use App;
use Illuminate\Support\Facades\DB;
use App\Services\Shop\ProductService;
use App\Repositories\Shop\ProductRepository;
use App\Repositories\Shop\ShareRepository;
use App\Services\System\AdminActivityService;
use Exception;
use Session;
use App\Services\Shop\Contracts\ProductInterface;

class ShareService extends ProductService implements ProductInterface{

    protected $shareRepository;
    /**
     * ShareService constructor.
     *
     * @param 
     */
    public function __construct(
    	AdminActivityService $adminLog,
    	ProductRepository $productRepository,
        ShareRepository $shareRepository
    ) {
        parent::__construct($adminLog,$productRepository);
        $this->shareRepository = $shareRepository;
    }

    /**
     * 依照類別id找到商品
     * @param int $id
     * @return array
     */
    public function findByCategoryId($id)
    {
        return $this->productRepository->findByCategoryId($id);
    }
    /**
     * 更新
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('a_token');
            $result = curlApi(env('API_URL').'/product/modify_product',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail'=> $result['detail']];
        }
    }


    /**
     * 使用商品
     * @param int $product_id
     * @param int $quantity
     * @param array $paramenters
     * @return array
     */
    public function useProduct($product_id, $quantity, $parameters = [])
    {
        DB::beginTransaction();
        try{
            $data = [
                'product_id' => $product_id,
                'quantity' => $quantity
            ];
            $data['token'] = Session::get('m_token');
            $result = curlApi(env('API_URL').'/product/use',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'].$result['detail']];
        }
        
    }

    /**
     * 權利碼發行紀錄相關
     */

    /**
     * 權利碼發行
     * @param date $start
     * @param date $end
     * @return array
     */
    public function getShareRecords($start,$end)
    {
        return $this->shareRepository->all($start,formatEndDate($end));
        
    }

    /**
     * 取得目前權利碼數量資料
     * @param date $start
     * @param date $end
     * @return array
     */
    public function getNowShare($start = null,$end = null)
    {
        $data = $this->shareRepository->getNowShare($start,formatEndDate($end));
        return [
            'all' => $data->all_share,
            'sell' => $data->sell_share,
            'now' => $data->all_share-$data->sell_share
        ];
        
    }

    /**
     * 權利碼發行
     * @param int $amount
     * @return array
     */
    public function addShare($amount)
    {
        DB::beginTransaction();
        try{
            $data['amount'] = $amount;
            $data['token'] = Session::get('a_token');
            $result = curlApi(env('API_URL').'/account/company_share_modify',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'].$result['detail']];
        }
        
    }
}
