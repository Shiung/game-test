<?php
namespace App\Services\Shop;

use App;
use App\Repositories\Shop\ProductUseRecordRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class ProductUseRecordService {
    
    protected $recordRepository;
    protected $adminLog;
    protected $feature_name = '商品使用記錄';

    /**
     * ProductUseRecordService constructor.
     * @param AdminActivityService $adminLog
     * @param ProductUseRecordRepository $recordRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        ProductUseRecordRepository $recordRepository
    ) {
        $this->adminLog = $adminLog;
        $this->recordRepository = $recordRepository;
    }

    /**
     *  依照類型取得所有訊息資料
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($start,$end)
    {
        return $this->recordRepository->all($start,formatEndDate($end));
    }
    
    /**
     *  依照會員取得的資料(for 前台)
     * @param int $member_id
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function allByMember($member_id,$start,$end)
    {
        return $this->recordRepository->allByMember($member_id,$start,formatEndDate($end));
    }



  
}
