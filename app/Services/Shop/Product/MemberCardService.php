<?php
namespace App\Services\Shop\Product;

use App;
use Illuminate\Support\Facades\DB;
use App\Services\Shop\ProductService;
use App\Repositories\Shop\ProductRepository;
use App\Repositories\Shop\ProductMemberLevelRepository;
use App\Services\System\AdminActivityService;
use Exception;
use Session;
use App\Services\Shop\Contracts\ProductInterface;

class MemberCardService extends ProductService implements ProductInterface{

    protected $productMemberLevelRepository;
    /**
     * MemberCardService constructor.
     *
     * @param AdminActivityService $adminLog,
     * @param ProductRepository $productRepository,
     * @param ProductMemberLevelRepository $productMemberLevelRepository
     */
    public function __construct(
    	AdminActivityService $adminLog,
    	ProductRepository $productRepository,
        ProductMemberLevelRepository $productMemberLevelRepository
    ) {
        parent::__construct($adminLog,$productRepository);
        $this->productMemberLevelRepository = $productMemberLevelRepository;
    }


    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id,$data)
    {
        DB::beginTransaction();
        try{
            $this->productRepository->update($id,[
                'name' => $data['name'],
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'subtract' => $data['subtract'],
            ]);
            //更新詳細資訊
            $this->productMemberLevelRepository->update($id,[
                'tree_name' => $data['tree_name'],
            ]);
            //新增log
            $this->adminLog->add([ 'content' =>  '更新資訊 product_id：'.$id ,'type' => '商品']); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 新增商品
     * @param array $data
     * @return array
     */
    public function add($data)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('a_token');
            $data['category'] = 4;
            $result = curlApi(env('API_URL').'/product/create_product_membercard',$data); 
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
     * 使用商品
     * @param int $product_id
     * @param int $quantity
     * @param array $paramenters
     * @return array
     */
    public function useProduct($product_id, $quantity, $paramenters = [])
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
