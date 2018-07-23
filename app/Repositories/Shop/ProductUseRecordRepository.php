<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\ProductUseRecord;

class ProductUseRecordRepository
{
    protected $record;
    /**
     * ProductUseRecordRepository constructor.
     *
     * @param ProductUseRecord $record
     */
    public function __construct(ProductUseRecord $record)
    {
        $this->record = $record;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->record->with('product')
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 
     * @param $member_id,$start,$end
     * @return Collection
     */
    public function allByMember($member_id,$start,$end)
    {
        return $this->record->with('product')
                ->where('member_id',$member_id)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }


}