<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\ProductBag;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductBagRepository
{
    protected $bag;
    /**
     * ProductBagRepository constructor.
     *
     * @param ProductBag $bag
     */
    public function __construct(ProductBag $bag)
    {
        $this->bag = $bag;
    }

    /**
     * 計算特定類別的商品有幾個
     * @param $member_id,$category_id
     * @return int
     */
    public function getProductCountByCategoryId($member_id,$category_id)
    {
        return $this->bag
                ->join('products AS p', 'p.id', '=', 'product_bags.product_id')
                ->where('product_bags.member_id',$member_id)
                ->where('p.product_category_id',$category_id)
                ->sum('product_bags.quantity');
    }

    /**
     * 取得特定類別中的其中一個商品資料
     * @param $member_id,$category_id
     * @return int
     */
    public function getProductByCategoryId($member_id,$category_id)
    {
        return $this->bag
                ->join('products AS p', 'p.id', '=', 'product_bags.product_id')
                ->where('product_bags.member_id',$member_id)
                ->where('p.product_category_id',$category_id)
                ->first();
    }


}