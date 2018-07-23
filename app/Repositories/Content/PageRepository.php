<?php
namespace App\Repositories\Content;

use Doctrine\Common\Collections\Collection;
use App\Models\Content\Page;

class PageRepository
{
    protected $page;
    /**
     * PageRepository constructor.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * 回傳列表
     * @param $status 
     * @return Collection
     */
    public function all($status)
    {
        return $this->page->where('status','LIKE',$status)->get();
    }

     /**
     * 列表分頁版（給前台）
     * @param $type,$page
     * @return Collection
     */
    public function allToPaginate($page)
    {
        return $this->page
                ->where('status',1)
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
        return $this->page->find($id);
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->page->insertGetId($data);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->page->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 刪除資料
     * @param id
     * @return Collection
     */
    public function delete($id)
    {  
        return $this->page->find($id)->delete();
    }
    
    
    
    /**
     * 依照code回傳特定資料
     * @param $code,$status
     * @return Collection
     */
    public function getPageByCode($code,$status = 1)
    {
        return $this->page->where('code',$code)->where('status','LIKE',$status)->first();
    }

    

}