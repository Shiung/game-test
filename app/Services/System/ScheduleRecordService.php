<?php
namespace App\Services\System;

use App;
use App\Repositories\System\ScheduleRecordRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class ScheduleRecordService {
    
    protected $logRepository;
    /**
     * 初始化
     * @param ScheduleRecordRepository $logRepository
     */
    public function __construct(ScheduleRecordRepository $logRepository){
        $this->logRepository = $logRepository;
    }


    /**
     * 取得所有資料
     * @param date $start,
     * @param date $end
     * @param string $name
     * @return Collection
     */
    public function all($start,$end,$name = '%')
    {
        return $this->logRepository->all($start,formatEndDate($end),$name);
    }

    /**
     * 取得排程名稱
     * @param date $start,
     * @param date $end
     * @return Collection
     */
    public function getNames($start,$end)
    {
        return $this->logRepository->getNames($start,formatEndDate($end));
    }

    /**
     * 尋找單一資料
     * @param int $id
     * @return Collection
     */
    public function find($id)
    {
        return $this->logRepository->find($id);
    }



}