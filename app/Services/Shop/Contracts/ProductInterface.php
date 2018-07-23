<?php 
namespace App\Services\Shop\Contracts;

/**
 * 賭盤共同操作
 *
 * @license MIT
 */

interface ProductInterface
{

    /**
     * 使用
     *
     * @param $quantity    商品數量
     * @param integer $id     商品id 
     * @param array $paramenters     商品參數
     * 
     * @return array
     */
    public function useProduct($product_id,$quantity,$paramenters = null);
}
