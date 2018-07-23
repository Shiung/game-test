<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\ProductRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class ProductService {
    
    protected $productRepository;
    protected $adminLog;

    /**
     * ProductService constructor.
     * @param AdminActivityService $adminLog
     * @param ProductRepository $productRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        ProductRepository $productRepository
    ) {
        $this->adminLog = $adminLog;
        $this->productRepository = $productRepository;
    }

    /**
     *  依照類型取得所有訊息資料
     * @param int $category_id,
     * @param int $status
     * @return collection 
     */
    public function all($category_id,$status)
    {
        return $this->productRepository->all($category_id,$status);
    }
    
    /**
     *  依照類型取得所有訊息資料(分頁)
     * @param int $category_id
     * @param int $page
     * @return collection 
     */
    public function allToPaginate($category_id,$page)
    {
        return $this->productRepository->allToPaginate($category_id,$page);
    }

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    /**
     * 更新上下架狀態
     * @param int $id, 
     * @param int $status
     * @return array
     */
    public function changeStatus($id,$status)
    {
        DB::beginTransaction();
        try{
            $this->productRepository->update($id,[
                'status' => $status
            ]);
            //新增log
            $this->adminLog->add([ 'content' =>  '更新上下狀態 product_id：'.$id ,'type' => '商品']); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    
    

    /**
     * 購買商品
     * @param int $product_id,
     * @param int $quantity
     * @return array
     */
    public function buy($product_id,$quantity)
    {
        DB::beginTransaction();
        try{
            $data['product_id'] = $product_id;
            $data['quantity'] = $quantity;
            $data['token'] = Session::get('m_token');
            $result = curlApi(env('API_URL').'/product/buy',$data); 
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
