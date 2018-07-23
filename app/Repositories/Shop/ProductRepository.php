<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\Product;

class ProductRepository
{
    protected $product;
    /**
     * ChargeRepository constructor.
     *
     * @param Charge $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $category_id,$status
     * @return Collection
     */
    public function all($category_id,$status)
    {
        return $this->product->with('category')
                ->where('product_category_id', 'LIKE', $category_id)
                ->where('status', 'LIKE',$status)
                ->get();
    }

    /**
     * 列表分頁版（給前台）
     * @param $category_id,$page
     * @return Collection
     */
    public function allToPaginate($category_id,$page)
    {
        return $this->product->with('category')
                ->where('product_category_id', $category_id)
                ->where('status', 1)
                ->orderBy('created_at','desc')
                ->paginate($page);
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->product->withTrashed()->find($id);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return bool
     */
    public function update($id,$data)
    {  
        $item = $this->product->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 刪除資料
     * @param id
     * @return bool
     */
    public function delete($id)
    {  
        return $this->product->find($id)->delete();
    }

    /**
     * 依照category_id找到商品（for單一商品   權利碼/專屬權利碼）
     * @param category_id
     * @return Collection
     */
    public function findByCategoryId($category_id)
    {
        return $this->product->where('product_category_id',$category_id)->first();
    }


}