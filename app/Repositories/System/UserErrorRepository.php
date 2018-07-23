<?php
namespace App\Repositories\System;

use Doctrine\Common\Collections\Collection;
use App\Models\Log\UserError;

class UserErrorRepository
{
    protected $log;
    /**
     * UserErrorRepository constructor.
     *
     * @param UserError $log
     */
    public function __construct(UserError $log)
    {
        $this->log = $log;
    }

    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->log
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 新增
     * @param $data
     * @return Collection
     */
    public function add($data)
    {
        return $this->log->create($data);
    }
 

}