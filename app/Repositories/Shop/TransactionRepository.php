<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\Transaction;

class TransactionRepository
{
    protected $transaction;
    /**
     * ThargeRepository constructor.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($type,$start,$end)
    {
        return $this->transaction->with('product')
                ->where('type','LIKE',$type)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 依照商品類型、日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function allByCategoryId($type,$category_id,$start,$end)
    {
        return $this->transaction
                ->join('products AS p', 'p.id', '=', 'transactions.product_id')
                ->join('members AS m', 'm.user_id', '=', 'transactions.receive_member_id')
                ->where('transactions.type','LIKE',$type)
                ->where('p.product_category_id','LIKE',$category_id)
                ->whereBetween('transactions.created_at', [$start,$end])
                ->select('m.name AS member_name','p.name AS product_name','transactions.*')
                ->get();
    }

    /**
     * 特定會員取得商品的紀錄
     * @param $member_id,$start,$end
     * @return Collection
     */
    public function allByReceiveMember($member_id,$start,$end)
    {
        return $this->transaction->with('product')
                ->where('receive_member_id',$member_id)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 特定會送出商品的紀錄
     * @param $member_id,$start,$end
     * @return Collection
     */
    public function allByTransferMember($member_id,$start,$end)
    {
        return $this->transaction->with('product')
                ->where('transfer_member_id',$member_id)
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
        return $this->transaction->find($id);
    }



}