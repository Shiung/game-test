<?php
namespace App\Presenters\Shop;

use App\Models\Shop\Product;

class ProductPresenter
{

    protected $categoryRepository;
    //需要直接計算顯示庫存的商品類別id
    protected $origin_qty = [1,4,5,6];

    /**
     * ProductPresenter constructor.
     *
     * @param 
     */
    public function __construct() {
    }

     /**
     * 顯示剩餘數量
     *
     * @param  Product $product
     * @param  array  $share_info
     * @return string
     */
    public function showQuantity(Product $product,$share_info=[])
    {

        if (in_array($product->product_category_id, $this->origin_qty)) {
            //照商品數量顯示
            if($product->subtract == 1){
                return number_format($product->quantity);
            } else {   
                //不扣庫存，顯示數量無限
                return '∞';
            }
        } else if ($product->product_category_id == 3){
            //專屬娛樂幣
            return number_format($share_info['own_share']);
        } else if($product->product_category_id == 2) {
            //娛樂幣
            return number_format($share_info['share']);
        }
       
    }

    /**
     * 顯示我的商品圖片
     *
     * @param  Product $product
     * @return string
     */
    public function showMyProductImg(Product $product)
    {

        if($product->product_category_id == 5){
            return asset('front/img/icon/card/card_invite_01.png');
        } else {
            return asset($product->icon);
        }
       
    }


}