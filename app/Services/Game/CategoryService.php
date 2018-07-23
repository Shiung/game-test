<?php
namespace App\Services\Game;

use App;
use App\Repositories\Game\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class CategoryService {
    
    protected $categoryRepository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $chargeRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     *  依照類型取得所有資料
     * @param 
     * @return collection 
     */
    public function all()
    {
        return $this->categoryRepository->all();
    }

    /**
     *  取得球類大類別
     * @param 
     * @return collection 
     */
    public function allMainCategories()
    {
        return $this->categoryRepository->allMainCategories();
    }

    /**
     *  依照球種類型顯示不同比賽類別
     * @param $type
     * @return collection 
     */
    public function allByType($type)
    {
        return $this->categoryRepository->allByType($type);
    }


    /**
     * 依照id查詢資料
     * $id
     * @return collection
     */
    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

   


  
}
