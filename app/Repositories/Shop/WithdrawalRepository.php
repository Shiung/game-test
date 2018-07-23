<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\Withdrawal;

class WithdrawalRepository
{
    protected $charge;
    /**
     * WithdrawalRepository constructor.
     *
     * @param Withdrawal $withdrawal
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->withdrawal
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
        return $this->withdrawal
                ->where('member_id',$member_id)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->withdrawal->find($id);
    }



}