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

class OwnShareService extends ProductService implements ProductInterface{


    /**
     * ShareService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param ProductRepository $productRepository
     * @param ShareRepository $shareRepository
     */
    public function __construct(
    	AdminActivityService $adminLog,
    	ProductRepository $productRepository,
        ShareRepository $shareRepository
    ) {
        parent::__construct($adminLog,$productRepository);
    }

    /**
     * 依照類別id找到商品
     * @param int $id
     * @return Collection
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
     * @param $quantity
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

    
}
