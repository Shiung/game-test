<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\CategoryRepository;
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
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

   


  
}
