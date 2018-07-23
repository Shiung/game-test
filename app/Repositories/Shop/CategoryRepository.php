<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\ProductCategory;

class CategoryRepository
{
    protected $category;
    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(ProductCategory $category)
    {
        $this->category = $category;
    }


    /**
     * 回傳列表
     * @return Collection
     */
    public function all()
    {
        return $this->category->orderBy('sort_order','asc')->get();
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->category->find($id);
    }

   



}