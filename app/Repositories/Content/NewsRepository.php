<?php
namespace App\Repositories\Content;

use Doctrine\Common\Collections\Collection;
use App\Models\Content\News;

class NewsRepository
{
    protected $news;
    /**
     * NewsRepository constructor.
     *
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * 依照日期區間回傳列表（給後台）
     * @param $$type,start,$end
     * @return Collection
     */
    public function all($type,$start,$end)
    {
        return $this->news
                ->where('type',$type)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

     /**
     * 列表分頁版（給前台）
     * @param $type,$page
     * @return Collection
     */
    public function allToPaginate($type,$page)
    {
        return $this->news
                ->where('status',1)
                ->where('type',$type)
                ->orderBy('post_date','desc')
                ->paginate($page);
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->news->find($id);
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->news->insertGetId($data);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->news->find($id);
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
        return $this->news->find($id)->delete();
    }
    


}