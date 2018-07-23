<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\ProductBagRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductBagService {
    
    protected $bagRepository;
    protected $feature_name = '我的商品';

    /**
     * ProductBagService constructor.
     * @param ProductBagRepository $bagRepository
     */
    public function __construct(
        ProductBagRepository $bagRepository
    ) {
        $this->bagRepository = $bagRepository;
    }

    /**
     *  依照會員取得的資料(for 前台)
     * @param int $member_id
     * @param int $category_id
     * @return collection 
     */
    public function getProductCountByCategoryId($member_id,$category_id)
    {
        return $this->bagRepository->getProductCountByCategoryId($member_id,$category_id);
    }

    /**
     *  取得特定商品類別中的第一個商品資料
     * @param int $member_id
     * @param int $category_id
     * @return collection 
     */
    public function getProductByCategoryId($member_id,$category_id)
    {
        return $this->bagRepository->getProductByCategoryId($member_id,$category_id);
    }



  
}
