<?php
namespace App\Repositories\Account;

use Doctrine\Common\Collections\Collection;
use App\Models\Account\Account;
use App\Models\Account\AccountRecord;

class AccountRepository
{
    protected $account;
    protected $record;
    /**
     * TransferRepository constructor.
     *
     * @param Transfer $transfer
     */
    public function __construct(Account $account,AccountRecord $record)
    {
        $this->account = $account;
        $this->record = $record;
    }

    /**
     * 依照日期區間/帳戶回傳列表
     * @param $account_id,start,$end
     * @return Collection
     */
    public function allByAccount($account_id,$start,$end)
    {
        return $this->record
                ->where('account_id',$account_id)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 依照轉帳類型/日期區間/帳戶回傳列表
     * @param $account_id,$type,start,$end
     * @return Collection
     */
    public function allByAccountType($account_id,$type,$start,$end)
    {
        return $this->record
                ->where('account_id',$account_id)
                ->where('type','LIKE', $type)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 依照帳戶類型/日期區間/使用者回傳列表
     * @param $member_id,$account_type,start,$end
     * @return Collection
     */
    public function allRecordByAccountType($member_id,$account_type,$start,$end)
    {
        return $this->record
                ->join('accounts AS a', 'a.id', '=', 'account_records.account_id')
                ->where('a.member_id',$member_id)
                ->where('a.type','LIKE', $account_type)
                ->whereBetween('account_records.created_at', [$start,$end])
                ->select('a.type AS account_type','account_records.*')
                ->get();
    }

    /**
     * 依照日期區間取得資料
     * @param start,$end
     * @return Collection
     */
    public function allRecordByDateRange($start,$end)
    {
        return $this->record
                ->join('accounts as A', 'A.id', '=', 'account_records.account_id')
                ->join('users as U', 'U.id', '=', 'A.member_id')
                ->join('members as M', 'U.id', '=', 'M.user_id')
                ->whereBetween('account_records.created_at', [$start,$end])
                ->orderBy('id','desc')
                ->select('U.username', 'account_records.*', 'M.name','A.type AS account_type')
                ->get();
    }


}