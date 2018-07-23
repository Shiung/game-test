<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\Share;
use App\Models\Shop\ShareRecord;

class ShareRepository
{
    protected $share;
    protected $record;
    /**
     * ShareRepository constructor.
     *
     * @param Share $share,ShareRecord $record
     */
    public function __construct(Share $share, ShareRecord $record)
    {
        $this->share = $share;
        $this->record = $record;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($start = null,$end = null)
    {
        if($start && $end){
            return $this->record
                ->whereBetween('created_at', [$start,$end])
                ->get();
        } else {
            return $this->record->all();
        }

        
    }


    /**
     * 取得目前權利碼數量資訊
     * @return Collection
     */
    public function getNowShare()
    {  
        return $this->share->find(1);
    }




}