<?php
namespace App\Services\Account;

use App;
use App\Repositories\Account\AccountRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class AccountService {
    
    protected $accountRepository;
    protected $adminLog;
    protected $feature_name = '帳戶';

    /**
     * AccountService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param AccountRepository $accountRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        AccountRepository $accountRepository
    ) {
        $this->adminLog = $adminLog;
        $this->accountRepository = $accountRepository;
    }

    /**
     *  依照帳戶/日期區間取得資料
     * @param int $account_id
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByAccount($account_id,$start,$end)
    {
        return $this->accountRepository->allByAccount($account_id,$start,formatEndDate($end));
    }

    /**
     *  依照帳戶/帳戶明細類型/日期區間取得資料
     * @param int $account_id
     * @param string $type
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByAccountType($account_id,$type,$start,$end)
    {
        return $this->accountRepository->allByAccountType($account_id,$type,$start,formatEndDate($end));
    }

    /**
     *  依照使用者/帳戶類型/日期區間取得資料
     * @param int $member_id
     * @param string $account_type
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allRecordByAccountType($member_id,$account_type,$start,$end)
    {
        return $this->accountRepository->allRecordByAccountType($member_id,$account_type,$start,formatEndDate($end));
    }
    
    /**
     *  依照日期區間取得資料
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allRecordByDateRange($start,$end)
    {
        return $this->accountRepository->allRecordByDateRange($start,formatEndDate($end));
    }
  
}
