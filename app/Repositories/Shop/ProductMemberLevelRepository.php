<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\ProductMemberLevel;

class ProductMemberLevelRepository
{
    protected $productMemberLevel;
    /**
     * ProductMemberLevelRepository constructor.
     *
     * @param ProductMemberLevel $productMemberLevel
     */
    public function __construct(ProductMemberLevel $productMemberLevel)
    {
        $this->productMemberLevel = $productMemberLevel;
    }



    /**
     * 更新資料
     * @param id, $data
     * @return bool
     */
    public function update($id,$data)
    {  
        $item = $this->productMemberLevel->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }

   

}