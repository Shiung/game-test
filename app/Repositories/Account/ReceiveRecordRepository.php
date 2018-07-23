<?php
namespace App\Repositories\Account;

use Doctrine\Common\Collections\Collection;
use App\Models\Account\AccountReceiveRecord;

class ReceiveRecordRepository
{
    protected $record;
    /**
     * ReceiveRecordRepository constructor.
     *
     * @param AccountReceiveRecord $record
     */
    public function __construct(AccountReceiveRecord $record)
    {
        $this->record = $record;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($status,$start,$end)
    {
        return $this->record->with('members')
                ->where('status','LIKE',$status)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 
     * @param $member_id,$start,$end
     * @return Collection
     */
    public function allByMemberToPaginate($member_id,$status,$start,$end,$page)
    {
        return $this->record->with('account')
                ->where('member_id',$member_id)
                ->where('status','LIKE',$status)
                ->whereBetween('created_at', [$start,$end])
                ->paginate($page);
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->record->find($id);
    }

   


}