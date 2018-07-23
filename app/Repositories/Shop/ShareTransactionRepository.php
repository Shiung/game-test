<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\ShareTransaction;

class ShareTransactionRepository
{
    protected $transaction;
    /**
     * ShareTransactionRepository constructor.
     *
     * @param ShareTransaction $transaction
     */
    public function __construct(ShareTransaction $transaction)
    {
        $this->transaction = $transaction;
    }


    /**
     * 依照狀態回傳列表
     * @param int $status,
     * @param date $start
     * @param date $end
     * @return Collection
     */
    public function allByStatus($status,$start,$end)
    {
        return $this->transaction
                ->where('status','LIKE',$status)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 特定會員掛單紀錄
     * @param int $member_id
     * @param int $status
     * @param date $start
     * @param date $end
     * @return Collection
     */
    public function allBySellerId($member_id,$status,$start,$end)
    {
        return $this->transaction
                ->where('seller_id',$member_id)
                ->where('status','LIKE',$status)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 特定會員購買成交紀錄
     * @param int $member_id
     * @param int $status
     * @param date $start
     * @param date $end
     * @return Collection
     */
    public function allByBuyerId($member_id,$status,$start,$end)
    {
        return $this->transaction
                ->where('buyer_id',$member_id)
                ->where('status','LIKE',$status)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 回傳最便宜的掛單
     * @param int $status
     * @param int $limit
     * @param int $member_id
     * @return Collection
     */
    public function getCheapestDatas($status,$limit,$member_id = null)
    {
        if($member_id){
            return $this->transaction
                ->where('seller_id',$member_id)
                ->where('status','LIKE',$status)
                ->orderBy('price', 'asc')
                ->take($limit)
                ->get();
        } else {
            //不分會員排序
            return $this->transaction
                ->where('status','LIKE',$status)
                ->orderBy('price', 'asc')
                ->take($limit)
                ->get();
        }
        
    }

    /**
     * 依照id回傳特定資料
     * @param int id
     * @return Collection
     */
    public function find($id)
    {
        return $this->transaction->find($id);
    }



}