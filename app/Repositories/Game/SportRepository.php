<?php
namespace App\Repositories\Game;

use Doctrine\Common\Collections\Collection;
use App\Models\Sport\Sport;

class SportRepository
{
    protected $sport;
    /**
     * SportRepository constructor.
     *
     * @param Sport $sport
     */
    public function __construct(Sport $sport)
    {
        $this->sport = $sport;
    }

    /**
     * 依照日期區間回傳列表（給後台）
     * @param $category_id,$status,$start,$end
     * @return Collection
     */
    public function all($category_id,$status,$start = null,$end = null)
    {
        if($start && $end ){
            return $this->sport
                ->where('sport_category_id',$category_id)
                ->whereIn('status', $status)
                ->whereBetween('taiwan_datetime', [$start,$end])
                ->get();
            
        } else {
            return $this->sport
                ->where('sport_category_id',$category_id)
                ->whereIn('status', $status)
                ->get();
        }
        
    }

    /**
     * 依照單一賽事狀態、類別顯示賽程列表[前台]
     * @param $category_id,$status
     * @return Collection
     */
    public function getSportsByStatus($category_id,$status)
    {
        return $this->sport
                ->where('sport_category_id',$category_id)
                ->where('status', $status)
                ->get();
        
    }

    /**
     * 依照類型、日期區間回傳列表（給後台）
     * @param $category_id,$status,$start,$end
     * @return Collection
     */
    public function getHistorySportsByType($category_id,$status,$start = null,$end = null)
    {
        return $this->sport
                ->where('sport_category_id',$category_id)
                ->whereIn('status', $status)
                ->whereBetween('taiwan_datetime', [$start,$end])
                ->get();
            
        
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->sport->find($id);
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->sport->insertGetId($data);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->sport->find($id);
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
        return $this->sport->find($id)->delete();
    }

    


}