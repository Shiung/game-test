<?php
namespace App\Repositories\Game;

use Doctrine\Common\Collections\Collection;
use App\Models\Sport\SportCategory;

class CategoryRepository
{
    protected $category;
    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(SportCategory $category)
    {
        $this->category = $category;
    }

    /**
     * all
     * @param $type,start,$end
     * @return Collection
     */
    public function all()
    {
        return $this->category->all();
    }

    /**
     * 取得球類大類別
     * @return Collection
     */
    public function allMainCategories()
    {
        return $this->category->select('id', 'name', 'type')
            ->get()
            ->groupBy('type');
      
    }

    /**
     * 依照球種類型顯示不同比賽類別
     * @param $type
     * @return Collection
     */
    public function allByType($type)
    {
        return $this->category->where('type',$type)->get();
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