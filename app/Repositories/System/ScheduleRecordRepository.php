<?php
namespace App\Repositories\System;

use Doctrine\Common\Collections\Collection;
use App\Models\System\ScheduleRecord;

class ScheduleRecordRepository
{
    protected $log;
    /**
     * UserLoginepository constructor.
     *
     * @param UserError $log
     */
    public function __construct(ScheduleRecord $log)
    {
        $this->log = $log;
    }

    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($start,$end,$name)
    {
        return $this->log
                ->where('name','LIKE',$name)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 取得排程類型
     * @param $start,$end
     * @return Collection
     */
    public function getNames($start,$end)
    {
        return $this->log
                ->select('name')
                ->whereBetween('created_at', [$start,$end])
                ->groupBy('name')
                ->get();
    }

    /**
     * 找id
     * @param $id
     * @return Collection
     */
    public function find($id)
    {
        return $this->log->find($id);
    }

}