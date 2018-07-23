<?php
namespace App\Repositories\Game;

use Doctrine\Common\Collections\Collection;
use App\Models\Sport\Sport;

class CnChessRepository
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
     * 依照日期區間回傳列表
     * @param $category_id,$status,$start,$end
     * @return Collection
     */
    public function all($start = null,$end = null,$paginate = 1)
    {
        if($paginate == 1 ){
            return $this->allToPaginate($start,$end);
            
        } else {
            return $this->allNoPaginate($start,$end);
        }
        
    }

    /**
     * 依照日期區間回傳列表（給後台 有分頁）
     * @param $category_id,$status,$start,$end
     * @return Collection
     */
    public function allToPaginate($start = null,$end = null)
    {
        if($start && $end ){
            return $this->sport
                ->where('sport_category_id',4)
                ->whereBetween('created_at', [$start,$end])
                ->paginate(15);
            
        } else {
            return $this->sport
                ->where('sport_category_id',$category_id)
                ->paginate(15);
        }
        
    }

    /**
     * 依照日期區間回傳列表（給前台 無分頁）
     * @param $category_id,$status,$start,$end
     * @return Collection
     */
    public function allNoPaginate($start = null,$end = null)
    {
        if($start && $end ){
            return $this->sport
                ->where('sport_category_id',4)
                ->whereBetween('created_at', [$start,$end])
                ->get();
            
        } else {
            return $this->sport
                ->where('sport_category_id',$category_id)
                ->get();
        }
        
    }


    /**
     * 取得最新象棋場次
     * @return Collection
     */
    public function getLatestGame()
    {
        return $this->sport
                ->where('sport_category_id',4)
                ->orderBy('start_datetime','desc')
                ->first();
            
        
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


}