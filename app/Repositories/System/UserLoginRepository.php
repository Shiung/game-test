<?php
namespace App\Repositories\System;

use Doctrine\Common\Collections\Collection;
use App\Models\Log\UserLogin;

class UserLoginRepository
{
    protected $log;
    /**
     * UserLoginepository constructor.
     *
     * @param UserError $log
     */
    public function __construct(UserLogin $log)
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
        return $this->log->with('member')
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 依照日期區間/會員回傳列表
     * @param $user_id,start,$end
     * @return Collection
     */
    public function allByMember($user_id,$start,$end)
    {
        return $this->log
                ->where('user_id',$user_id)
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