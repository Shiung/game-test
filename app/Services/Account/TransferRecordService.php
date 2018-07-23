<?php
namespace App\Services\Account;

use App;
use App\Repositories\Account\TransferRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class TransferRecordService {
    
    protected $transferRepository;

    /**
     * TransferRecordService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param TransferRepository $transferRepository
     */
    public function __construct(
        AdminActivityService $adminLog, 
        TransferRepository $transferRepository
    ) {
        $this->adminLog = $adminLog;
        $this->transferRepository = $transferRepository;
    }

    /**
     *  依照類型取得所有資料
     * @param array $types
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($types = [],$start,$end)
    {
        return $this->transferRepository->all($types,$start,formatEndDate($end));
    }
    

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->transferRepository->find($id);
    }

   
    
  
}
